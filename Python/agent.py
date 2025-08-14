import psutil
import requests
import time
import platform
import json
import os
import threading
import wmi
import logging
import pythoncom # ¡Nuevo! Importamos la librería COM
from tkinter import Tk, Label, Entry, Button, messagebox

# --- CONFIGURACIÓN DE LOGGING ---
logging.basicConfig(
    filename='agent.log',
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)

# --- CONFIGURACIÓN ---
API_BASE_URL = "http://127.0.0.1:8000/api"
PC_IDENTIFIER = platform.node()
CONFIG_FILE = 'config.json'
SPECS_SENT_FLAG = 'specs_sent.flag'
REPORT_INTERVAL_SECONDS = 900 

# --- LÓGICA DE CONFIGURACIÓN Y TOKEN ---
def save_config(token):
    with open(CONFIG_FILE, 'w') as f:
        json.dump({'api_token': token}, f)

def load_config():
    if os.path.exists(CONFIG_FILE):
        with open(CONFIG_FILE, 'r') as f:
            try:
                return json.load(f)
            except json.JSONDecodeError:
                return None
    return None

# --- LÓGICA PARA OBTENER SPECS DE HARDWARE ---
def get_hardware_specs():
    logging.info("Recolectando especificaciones de hardware...")
    try:
        c = wmi.WMI()
        specs = {
            'cpu': c.Win32_Processor()[0].Name.strip(),
            'ram_total_gb': round(int(c.Win32_ComputerSystem()[0].TotalPhysicalMemory) / (1024**3)),
            'disks': [],
            'motherboard': f"{c.Win32_BaseBoard()[0].Manufacturer} {c.Win32_BaseBoard()[0].Product}"
        }
        for disk in c.Win32_DiskDrive():
            specs['disks'].append({
                'model': disk.Model.strip(),
                'size_gb': round(int(disk.Size) / (1024**3)),
                'type': 'SSD' if 'SSD' in disk.Model else 'HDD'
            })
        logging.info(f"Especificaciones recolectadas: {json.dumps(specs)}")
        return specs
    except Exception as e:
        logging.error(f"Error al recolectar especificaciones: {e}")
        return None

# --- LÓGICA DEL AGENTE ---
def get_system_metrics():
    cpu_usage = psutil.cpu_percent(interval=1)
    ram_usage = psutil.virtual_memory().percent
    disk_path = 'C:\\' if platform.system() == "Windows" else '/'
    disk_usage = psutil.disk_usage(disk_path).percent
    return {"pc_identifier": PC_IDENTIFIER, "cpu_usage": cpu_usage, "ram_usage": ram_usage, "disk_usage": disk_usage}

def send_data_to_server(endpoint, payload, api_token):
    url = f"{API_BASE_URL}/{endpoint}"
    logging.info(f"Enviando datos a {url}...")
    try:
        headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': f'Bearer {api_token}'
        }
        response = requests.post(url, data=json.dumps(payload), headers=headers, timeout=20)
        logging.info(f"Respuesta del servidor para '{endpoint}': Código {response.status_code}")
        if response.status_code != 200:
            logging.warning(f"Detalle de la respuesta: {response.text}")
        return response
    except requests.exceptions.RequestException as e:
        logging.error(f"Error de conexión al enviar a '{endpoint}': {e}")
        return None

def monitoring_loop(api_token):
    # --- ¡CORRECCIÓN CLAVE! ---
    # Inicializamos el entorno COM para este hilo.
    pythoncom.CoInitialize()
    
    logging.info("Iniciando bucle de monitoreo.")
    if not os.path.exists(SPECS_SENT_FLAG):
        specs = get_hardware_specs()
        if specs:
            response = send_data_to_server('specs', specs, api_token)
            if response and response.status_code == 200:
                logging.info("Especificaciones enviadas con éxito. Creando archivo flag.")
                open(SPECS_SENT_FLAG, 'a').close()
            else:
                logging.error("No se pudo enviar las especificaciones. Se reintentará en el próximo reinicio.")
    else:
        logging.info("El archivo 'specs_sent.flag' ya existe. Omitiendo envío de especificaciones.")

    while True:
        metrics = get_system_metrics()
        send_data_to_server('metrics', metrics, api_token)
        time.sleep(REPORT_INTERVAL_SECONDS)

# --- INTERFAZ GRÁFICA (sin cambios) ---
def ask_for_token_gui():
    window = Tk()
    window.title("Configuración de Pc Fast Mariquina")
    window.geometry("400x150")
    def on_save():
        token = entry.get().strip()
        if len(token) > 10:
            save_config(token)
            messagebox.showinfo("Éxito", "¡Token guardado! El monitoreo comenzará ahora.")
            window.destroy()
        else:
            messagebox.showerror("Error", "El token parece inválido.")
    Label(window, text="Por favor, pega el token de acceso de tu equipo:").pack(pady=10)
    entry = Entry(window, width=50)
    entry.pack(pady=5)
    Button(window, text="Guardar y Empezar a Monitorear", command=on_save).pack(pady=10)
    window.mainloop()

# --- PUNTO DE ENTRADA PRINCIPAL ---
if __name__ == "__main__":
    logging.info("Agente iniciado.")
    config = load_config()
    if not config or not config.get('api_token'):
        ask_for_token_gui()
        config = load_config()

    if config and config.get('api_token'):
        monitor_thread = threading.Thread(target=monitoring_loop, args=(config['api_token'],), daemon=True)
        monitor_thread.start()
        while True:
            time.sleep(1)
