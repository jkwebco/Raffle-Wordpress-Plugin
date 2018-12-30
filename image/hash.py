import hashlib
 
hasher = hashlib.md5()
with open('sample-out07891234.png', 'rb') as afile:
    buf = afile.read()
    hasher.update(buf)
print(hasher.hexdigest())
