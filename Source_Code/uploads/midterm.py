import cv2
import numpy as np
img = cv2.imread('midterm.png')
kernel = np.ones((2, 2), np.uint8)
erosion = cv2.erode(img,kernel,iterations = 1)
img = erosion
gray = cv2.cvtColor(img,cv2.COLOR_BGR2GRAY)
# #180 190
th, bw = cv2.threshold(gray,180,190,cv2.THRESH_BINARY_INV)
contours,_ = cv2.findContours(bw, cv2.RETR_LIST, cv2.CHAIN_APPROX_SIMPLE)
cntsSorted = sorted(contours, key=lambda x : cv2.contourArea(x), reverse = True)
for cnt in cntsSorted:
	area = cv2.contourArea(cnt)
	if area > 185:
		(x,y,w,h) = cv2.boundingRect(cnt)
		cv2.rectangle(img,(x,y),(x+w , y+h),(0,0,255),2)
cv2.imshow('Giua ky',img)
cv2.waitKey(0)
