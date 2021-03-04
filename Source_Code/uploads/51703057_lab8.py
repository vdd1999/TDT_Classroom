import cv2
import numpy as np

def STA(gray):
	w,h = gray.shape
	T = gray.mean()
	while TRUE:
		R1 =[]
		R2 = []
		for i in range(w):
			for j in range(h):
				if gray[i,j] > T:
					R1.append(gray[i,j])
				else:
					R2.append(gray[i,j])
		m1 = np.mean(R1)
		m2 = np.mean(R2)
		new_T = (m1+m2)/2
		if abs(new_T - T)<0.01:
			break
		T = new_T
	b = np.zeros((w,h))
	for i in range(w):
		for j in range(h):
			if gray[i,j] > T:
				b[i,j] = 1
			else:
				b[i,j] = 0
	return b

img = cv2.imread('lena.jpg')
gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
STA(gray)
