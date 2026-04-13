import sys
import warnings
warnings.filterwarnings("ignore")  # 🔹 suppress all warnings
import joblib

import numpy as np

# load trained model
model = joblib.load("C:\\xampp\\htdocs\\burnout_predict\\synthetic_employee_burnout.pkl")

# ✅ EXPECT EXACT ORDER FROM PHP
# trt is FIRST
Age = float(sys.argv[1])
Gender = float(sys.argv[2])
JobRole = float(sys.argv[3])
Experience = float(sys.argv[4])
WorkHoursPerWeek = float(sys.argv[5])
RemoteRatio = float(sys.argv[6])
SatisfactionLevel = float(sys.argv[7])
StressLevel = float(sys.argv[8])

# ✅ CORRECT DATA FORMAT (NUMBERS, NOT STRINGS)
data = np.array([[
    Age,Gender,JobRole,Experience,WorkHoursPerWeek,RemoteRatio,SatisfactionLevel,StressLevel
]])

# Predict probability for Burnout class (class 1)
proba = model.predict_proba(data)[0][1]  # probability of Burnout
percent = proba * 100

# Map probability directly to output
if percent <= 33:
    result = f"No Burnout ({percent:.0f}%) - Manageable"
elif percent <= 66:
    result = f"No Burnout ({percent:.0f}%) - Concerning"
else:
    result = f"Burnout Detected ({percent:.0f}%) - Critical"

print(f"{percent:.0f}|{result}")