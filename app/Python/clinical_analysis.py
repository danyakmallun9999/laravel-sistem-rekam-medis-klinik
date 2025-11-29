import sys
import json

def analyze(vital_signs):
    alerts = []
    
    if not vital_signs:
        return alerts

    # Hypertension Risk
    if 'systolic' in vital_signs and 'diastolic' in vital_signs:
        try:
            systolic = int(vital_signs['systolic'])
            diastolic = int(vital_signs['diastolic'])

            if systolic >= 140 or diastolic >= 90:
                alerts.append({
                    'type': 'danger',
                    'title': 'Hypertension Risk',
                    'message': f"Blood pressure ({systolic}/{diastolic} mmHg) indicates hypertension. Monitor closely."
                })
            elif (systolic >= 120 and systolic < 140) or (diastolic >= 80 and diastolic < 90):
                alerts.append({
                    'type': 'warning',
                    'title': 'Pre-Hypertension',
                    'message': f"Blood pressure ({systolic}/{diastolic} mmHg) is elevated."
                })
        except (ValueError, TypeError):
            pass

    # Heart Rate Analysis
    if 'heart_rate' in vital_signs:
        try:
            hr = int(vital_signs['heart_rate'])
            if hr > 100:
                alerts.append({
                    'type': 'warning',
                    'title': 'Tachycardia',
                    'message': f"Heart rate ({hr} bpm) is elevated (Tachycardia)."
                })
            elif hr < 60:
                alerts.append({
                    'type': 'warning',
                    'title': 'Bradycardia',
                    'message': f"Heart rate ({hr} bpm) is low (Bradycardia)."
                })
        except (ValueError, TypeError):
            pass

    # Fever Detection
    if 'temperature' in vital_signs:
        try:
            temp = float(vital_signs['temperature'])
            if temp > 38.0:
                alerts.append({
                    'type': 'danger',
                    'title': 'High Fever',
                    'message': f"Body temperature ({temp} °C) indicates high fever."
                })
            elif temp > 37.5:
                alerts.append({
                    'type': 'warning',
                    'title': 'Fever',
                    'message': f"Body temperature ({temp} °C) is elevated."
                })
            elif temp < 35.0:
                alerts.append({
                    'type': 'danger',
                    'title': 'Hypothermia Risk',
                    'message': f"Body temperature ({temp} °C) is dangerously low."
                })
        except (ValueError, TypeError):
            pass

    # Hypoxia Detection
    if 'oxygen_saturation' in vital_signs:
        try:
            spo2 = int(vital_signs['oxygen_saturation'])
            if spo2 < 90:
                alerts.append({
                    'type': 'danger',
                    'title': 'Critical Hypoxia',
                    'message': f"Oxygen saturation ({spo2}%) is critically low. Immediate attention required."
                })
            elif spo2 < 95:
                alerts.append({
                    'type': 'warning',
                    'title': 'Hypoxia Risk',
                    'message': f"Oxygen saturation ({spo2}%) is below normal."
                })
        except (ValueError, TypeError):
            pass

    # BMI Calculation
    if 'height' in vital_signs and 'weight' in vital_signs:
        try:
            height_cm = float(vital_signs['height'])
            weight_kg = float(vital_signs['weight'])
            
            if height_cm > 0:
                height_m = height_cm / 100
                bmi = weight_kg / (height_m * height_m)
                bmi = round(bmi, 1)

                if bmi >= 30:
                    alerts.append({
                        'type': 'danger',
                        'title': 'Obesity',
                        'message': f"BMI is {bmi} (Obese). Risk factor for cardiovascular diseases."
                    })
                elif bmi >= 25:
                    alerts.append({
                        'type': 'warning',
                        'title': 'Overweight',
                        'message': f"BMI is {bmi} (Overweight)."
                    })
                elif bmi < 18.5:
                    alerts.append({
                        'type': 'warning',
                        'title': 'Underweight',
                        'message': f"BMI is {bmi} (Underweight)."
                    })
        except (ValueError, TypeError):
            pass

    return alerts

if __name__ == "__main__":
    try:
        if len(sys.argv) > 1:
            input_json = sys.argv[1]
            vital_signs = json.loads(input_json)
            results = analyze(vital_signs)
            print(json.dumps(results))
        else:
            print("[]")
    except Exception as e:
        # In case of error, return empty list to avoid breaking the app
        # print(f"Error: {e}", file=sys.stderr) 
        print("[]")
