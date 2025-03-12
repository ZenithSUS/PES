from datetime import datetime, timedelta
from json import dumps
import requests

device_name = "Mock Biometric Device"
users = [
    {"user_id": "16623", "name": "test"},
    {"user_id": "16624", "name": "test"},
    {"user_id": "16625", "name": "test"},
    {"user_id": "16626", "name": "test"},
]

def generate_mock_attendance():
    attendance_data = []
    for user in users:
        for i in range(1, 25):  
            check_in_time = datetime.now() - timedelta(days=i, hours=8)
            check_out_time = datetime.now() - timedelta(days=i, hours=1)
            attendance_data.append({
                "user_id": user["user_id"],
                "timestamp": check_in_time.isoformat(),
                "type": 0,
                "state": "Verified",
            })

            attendance_data.append({
                "user_id": user["user_id"],
                "timestamp": check_out_time.isoformat(),
                "type": 1,
                "state": "Verified",
            })
    return attendance_data

attendances = generate_mock_attendance()

url = "http://localhost:80/oas/bio/processattendances.php"
headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

attendance_json = dumps(attendances)
response = requests.post(url=url, data=attendance_json, headers=headers)
print(response.text)