
#pastes text -90 degrees on image ticket

from PIL import Image, ImageFont, ImageDraw



text = '07891234'
font = ImageFont.truetype(r'/home/userany/Downloads/_aiweb/image/arial.ttf', 20)
width, height = font.getsize(text)

#image1 = Image.new('RGBA', (200, 150), (0, 128, 0, 92))
image1=Image.open("raffle1.jpg")
#draw1 = ImageDraw.Draw(image1)
#draw1.text((0, 0), text=text, font=font, fill=(255, 128, 0))


# convert PIL Image to ndarray
im_arr = np.asarray(image1)

# random_noise() method will convert image in [0, 255] to [0, 1.0],
# inherently it use np.random.normal() to create normal distribution
# and adds the generated noised back to image
noise_img = random_noise(im_arr, mode='gaussian', var=0.05**2)
noise_img = (255*noise_img).astype(np.uint8)

image1 = Image.fromarray(noise_img)





image2 = Image.new('RGBA', (width, height), (0, 0, 128, 92))
draw2 = ImageDraw.Draw(image2)



draw2.text((0, 0), text=text, font=font, fill=(0, 255, 128))

image2 = image2.rotate(-90, expand=1)

px, py = 328, 74
sx, sy = image2.size
image1.paste(image2, (px, py, px + sx, py + sy), image2)


px, py = 328, 245
#sx, sy = image2.size
image1.paste(image2, (px, py, px + sx, py + sy), image2)

image1.show()

image1.save('sample-out'+text+'.png')
#Image.open('/home/userany/Downloads/_aiweb/image/sample-out'+text+'.png').show()

import hashlib
 
hasher = hashlib.md5()
with open('sample-out'+text+'.png', 'rb') as afile:
    buf = afile.read()
    hasher.update(buf)
print(hasher.hexdigest())
