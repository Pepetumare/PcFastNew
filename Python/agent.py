import psutil
import requests
import time
import platform
import json
import os
import threading
from tkinter import Tk, Label, Entry, Button, messagebox

# --- CONFIGURACIÓN ---
API_ENDPOINT = "http://127.0.0.1:8000/api/metrics"
PC_IDENTIFIER = platform.node()
CONFIG_FILE = 'config.json'
# El agente reportará cada 15 minutos en un entorno real. Para pruebas, puedes bajarlo a 60 segundos.
REPORT_INTERVAL_SECONDS = 900 

# --- FUNCIONES DE CONFIGURACIÓN ---

def save_token(token):
    """Guarda el token en el archivo de configuración."""
    with open(CONFIG_FILE, 'w') as f:
        json.dump({'api_token': token}, f)

def load_token():
    """Carga el token desde el archivo de configuración."""
    if os.path.exists(CONFIG_FILE):
        with open(CONFIG_FILE, 'r') as f:
            try:
                config = json.load(f)
                return config.get('api_token')
            except json.JSONDecodeError:
                return None
    return None

# --- LÓGICA DEL AGENTE ---

def get_system_metrics():
    """Recolecta las métricas clave del sistema."""
    cpu_usage = psutil.cpu_percent(interval=1)
    ram_usage = psutil.virtual_memory().percent
    disk_path = 'C:\\' if platform.system() == "Windows" else '/'
    disk_usage = psutil.disk_usage(disk_path).percent
    try:
        temps = psutil.sensors_temperatures()
        cpu_temp = temps['coretemp'][0].current if 'coretemp' in temps else None
    except (AttributeError, KeyError):
        cpu_temp = None

    return {
        "pc_identifier": PC_IDENTIFIER,
        "cpu_usage": cpu_usage,
        "ram_usage": ram_usage,
        "disk_usage": disk_usage,
        "cpu_temperature": cpu_temp
    }

def send_metrics_to_server(metrics, api_token):
    """Envía las métricas recolectadas al servidor web."""
    try:
        headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': f'Bearer {api_token}'
        }
        requests.post(API_ENDPOINT, data=json.dumps(metrics), headers=headers, timeout=15)
    except requests.exceptions.RequestException:
        # Silenciamos los errores de conexión para que el usuario no vea nada.
        # En un futuro se podría añadir un sistema de logs.
        pass

def monitoring_loop(api_token):
    """Bucle principal que se ejecuta en segundo plano."""
    while True:
        metrics = get_system_metrics()
        send_metrics_to_server(metrics, api_token)
        time.sleep(REPORT_INTERVAL_SECONDS)

# --- INTERFAZ GRÁFICA PARA EL TOKEN ---

def ask_for_token_gui():
    """Crea y muestra una ventana para que el usuario ingrese el token."""
    window = Tk()
    window.title("Configuración de Pc Fast Mariquina")
    window.geometry("400x150")
    window.resizable(False, False)

    def on_save():
        token = entry.get().strip()
        if len(token) > 10: # Validación simple
            save_token(token)
            messagebox.showinfo("Éxito", "¡Token guardado! El monitoreo comenzará ahora en segundo plano.")
            window.destroy()
        else:
            messagebox.showerror("Error", "El token parece inválido. Por favor, pégalo correctamente.")

    label = Label(window, text="Por favor, pega el token de acceso de tu equipo:", wraplength=380)
    label.pack(pady=10)

    entry = Entry(window, width=50)
    entry.pack(pady=5, padx=10)

    button = Button(window, text="Guardar y Empezar a Monitorear", command=on_save)
    button.pack(pady=10)
    
    window.mainloop()

# --- PUNTO DE ENTRADA PRINCIPAL ---

if __name__ == "__main__":
    api_token = load_token()

    if not api_token:
        ask_for_token_gui()
        api_token = load_token()

    if api_token:
        # Iniciamos el bucle de monitoreo en un hilo separado
        # para que la aplicación principal pueda cerrarse sin detener el agente.
        monitor_thread = threading.Thread(target=monitoring_loop, args=(api_token,), daemon=True)
        monitor_thread.start()
        # Mantenemos el script principal vivo para que el hilo daemon no muera inmediatamente.
        # En el .exe, esto no será necesario de la misma forma.
        while True:
            time.sleep(1)
