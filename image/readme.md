Objective: To create a unique image with a series of numbers...

with a unique image hash and save it on the DLT.



1) Create image with text on it rotated -90 degrees

Question: how to break the mold and keep original safe?

Answer: add some random noise to the image.

1) Now each hash is different or unique and only you recieve the orignal image, so nobody can regenerate the original image.

2) Of course each ticket number has to be assigned and image is sent to prospective winner.

3) Store Hash, Store Number, send image to claimer.

```
There is function random_noise() from the scikit-image package. 
It has several builtin noise patterns, such as gaussian, s&p 
(for salt and pepper noise), possion and speckle.

Below I show an example of how to use this method

from PIL import Image
import numpy as np
from skimage.util import random_noise

im = Image.open("test.jpg")
# convert PIL Image to ndarray
im_arr = np.asarray(im)

# random_noise() method will convert image in [0, 255] to [0, 1.0],
# inherently it use np.random.normal() to create normal distribution
# and adds the generated noised back to image
noise_img = random_noise(im_arr, mode='gaussian', var=0.05**2)
noise_img = (255*noise_img).astype(np.uint8)

img = Image.fromarray(noise_img)
img.show()

enter image description here
```


And getting the unique hash from the image

```
import hashlib
 
hasher = hashlib.md5()
with open('sample-out07891234.png', 'rb') as afile:
    buf = afile.read()
    hasher.update(buf)
print(hasher.hexdigest())
```
![alt text](https://github.com/jkwebco/Raffle-Wordpress-Plugin/blob/master/image/sample-out07891234.png)
