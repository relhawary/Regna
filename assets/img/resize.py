import os
from PIL import Image

# Input and output folders
input_folder = 'portfolio'
output_folder = os.path.join(input_folder, 'resized')

# Make sure output folder exists
os.makedirs(output_folder, exist_ok=True)

# Target size
target_size = (250, 250)

def resize_image(image_path, output_path):
    with Image.open(image_path) as img:
        img.thumbnail(target_size, Image.LANCZOS)  # Resize while keeping aspect ratio
        
        # Create a transparent or white background
        background = Image.new('RGBA', target_size, (255, 255, 255, 0))
        img_position = (
            (target_size[0] - img.size[0]) // 2,
            (target_size[1] - img.size[1]) // 2
        )
        
        # Paste image onto background
        background.paste(img, img_position, img if img.mode == 'RGBA' else None)
        
        # Save as PNG (if input image is RGBA or not, will retain alpha)
        output_path = output_path.rsplit('.', 1)[0] + '.png'  # Ensure PNG extension
        background.save(output_path, 'PNG')
        print(f"Resized and saved: {output_path}")

# Process all images
for filename in os.listdir(input_folder):
    if filename.lower().endswith(('.png', '.jpg', '.jpeg', '.webp')):
        input_path = os.path.join(input_folder, filename)
        output_path = os.path.join(output_folder, filename)
        try:
            resize_image(input_path, output_path)
        except Exception as e:
            print(f"Failed to process {filename}: {e}")

print("\nAll images resized!")
