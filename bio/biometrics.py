import ctypes
import sys

def hide_console():
    whnd = ctypes.windll.kernel32.GetConsoleWindow()
    if whnd != 0:
        ctypes.windll.user32.ShowWindow(whnd, 0)  # SW_HIDE = 0
        ctypes.windll.kernel32.CloseHandle(whnd)

hide_console()

from datetime import date, datetime
import requests
from json import dumps
from zk import ZK
from zk.exception import ZKErrorResponse, ZKErrorConnection, ZKNetworkError

ip_address = "192.168.10.200"
port = 4370

device_name = ""
users = []
attendances = []

def attendance2dict(attendance):
    return {
        "user_id": attendance.user_id,
        "timestamp": attendance.timestamp,
        "type": attendance.punch,
        "state": attendance.status
    }

def json_serial(obj):
    if isinstance(obj, (datetime, date)):
        return obj.isoformat()
    raise TypeError ("Type %s not serializable" % type(obj))

conn = None
zk = ZK(ip_address, port=port, timeout=10)

try:
    conn = zk.connect()
    conn.disable_device() 

    device_name = conn.get_device_name()
    users = conn.get_users()
    attendances = [attendance2dict(attn) for attn in conn.get_attendance()] 
except (ZKErrorResponse, ZKErrorConnection, ZKNetworkError, TimeoutError) as ex:
    print(f"Connection error: {str(ex)}")
except (Exception) as ex:
    print(f"Error: {str(ex)}")
finally:
    if conn:
        if (conn.is_enabled == False): conn.enable_device()
        if (conn.is_connect): conn.disconnect()

# print(f"Device: {device_name}")
# print(f"Users: {len(users)}")
# print(f"Attendances: {len(attendances)}")

if (len(attendances) > 0):
    # send the attendance data to your website
    
    #url = "http://localhost:80/PES/bio/processattendances.php" for testing
    # eto yung config papunta sa system naten
    # pwede rin i-access yan if may local ethernet using 
    # http://IPv4:port/PES/bio/processattendances.php for implementation

    with open("attendance-logs.json", "a") as f:
        f.write(dumps(attendances, default=json_serial))

    url = "http://localhost/PES/bio/processattendances.php" # the link to your website that will process the attendance data
    headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

    r = requests.post(url=url, data=dumps(attendances, default=json_serial), headers=headers)
    print(r.text)