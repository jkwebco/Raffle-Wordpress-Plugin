Brainstorm: Raffle Wordpress Plugin
Date: December 29, 2018
Facilitator: Daniel J.
Participants: current audience


🎯 Goals/Issues

What is the purpose of a raffle and how is it used as a plugin with Wordpress

    Wordpress Plugin Ticket Raffle
    Blockchain DLT
    Image PIL
    working with  Wordress  Database
    Smart contracts
    ImageHash 4.0 PyPi 
    Send an email of ticket
    Woocommerce


📚 Research

The typical  ticket that is issued to the client
raffel.jpg

each ticket has a number that it is stamped with.


```
from PIL import Image, ImageFont, ImageDraw

text = '785004'
font = ImageFont.truetype(r'/fonts/Arial.ttf', 50)
width, height = font.getsize(text)

image1 = Image.new('RGBA', (200, 150), (0, 128, 0, 92))
draw1 = ImageDraw.Draw(image1)
draw1.text((0, 0), text=text, font=font, fill=(255, 128, 0))

image2 = Image.new('RGBA', (width, height), (0, 0, 128, 92))
draw2 = ImageDraw.Draw(image2)
draw2.text((0, 0), text=text, font=font, fill=(0, 255, 128))

image2 = image2.rotate(30, expand=1)

px, py = 10, 10
sx, sy = image2.size
image1.paste(image2, (px, py, px + sx, py + sy), image2)

image1.show()

```
create smart contract on eth as DAPP


```
contract ImageInfo{
   mapping(address=>Image[]) private images;
   struct Image{
      string imageHash;
      string ipfsInfo;
   }
   function uploadImage(string hash, string ipfs) public{
       images[msg.sender].push(Image(hash,ipfs)); //
   }
}

```

code for running python on wordpress
A simple example to print Hello World! in a WordPress plugin

Create the plugin, register a shortcode:


```

<?php # -*- coding: utf-8 -*-
/* Plugin Name: Python embedded */

add_shortcode( 'python', 'embed_python' );

function embed_python( $attributes )
{
    $data = shortcode_atts(
        [
            'file' => 'hello.py'
        ],
        $attributes
    );

    $handle = popen( __DIR__ . '/' . $data['file'] . ' 2>&1', 'r' );
    $read = '';

    while ( ! feof( $handle ) )
    {
        $read .= fread( $handle, 2096 );
    }

    pclose( $handle );

    return $read;
}

```
Now you can use that shortcode in the post editor with [python] or [python file="filename.py"].

Put the Python scripts you want to use into the same directory as the plugin file. You can also put them into a directory and adjust the path in the shortcode handler.

Now create a complex Python script like this:

```
print("Hello World!")

```
And that’s all. Use the shortcode, and get this output:

On the console, I ran

chmod 777 hello.py



🚀 Suggestions/Ideas

Get the details on smart contracts and how to add 
💡Idea Deployment

    Deployment
    Get the Eth Blockchain hash
    add the image hash to the Eth blockchain
    save file to IPFS and add File location to Eth blockchain contract
    Write this stuff back to wordpress database
    Eth hash
    IPFS location
     Client must have email image for final validation.
    There must be a drawing 
    The game will have to have rules and engagement spelled out in the initial 
    purchase the ticket rules


💡Idea Image hash function

    Advantages
    is it immutable
    Disadvantage
    can it be changed by image manipulation?
    image hash is stored on server along with the ether hash


👉 Final Decision

Decide whether or not to write image and store on the fly or keep a copy. Decide how to incorporate ai into project.


✅ Action Items

    Action Item 1

    other wordpress  plugins 

    Raffle ticket woocommerce
    Wp raffle system

    live link



