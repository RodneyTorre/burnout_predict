import sys
import joblib
import numpy as np

# load trained model
model = joblib.load("synthetic_employee_burnout.pkl")

# ✅ EXPECT EXACT ORDER FROM PHP
# trt is FIRST
trt = float(sys.argv[1])
age = float(sys.argv[2])
wtkg = float(sys.argv[3])
hemo = float(sys.argv[4])
homo = float(sys.argv[5])
drugs = float(sys.argv[6])
karnof = float(sys.argv[7])
oprior = float(sys.argv[8])
z30 = float(sys.argv[9])
preanti = float(sys.argv[10])
race = float(sys.argv[11])
gender = float(sys.argv[12])
str2 = float(sys.argv[13])
strat = float(sys.argv[14])
symptom = float(sys.argv[15])
treat = float(sys.argv[16])
offtrt = float(sys.argv[17])
cd40 = float(sys.argv[18])
cd420 = float(sys.argv[19])
cd80 = float(sys.argv[20])
cd820 = float(sys.argv[21])

# ✅ CORRECT DATA FORMAT (NUMBERS, NOT STRINGS)
data = np.array([[
    trt, age, wtkg, hemo, homo, drugs, karnof, oprior,
    z30, preanti, race, gender, str2, strat,
    symptom, treat, offtrt, cd40, cd420, cd80, cd820
]])

# predict
prediction = model.predict(data)

# ✅ CLEAN OUTPUT FOR PHP
if prediction[0] == 1:
    print("Burnout Detected")
else:
    print("No Burnout")