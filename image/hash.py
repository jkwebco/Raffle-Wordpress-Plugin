import hashlib
 
hasher = hashlib.md5()
with open('sample-out.png', 'rb') as afile:
    buf = afile.read()
    hasher.update(buf)
print(hasher.hexdigest())
