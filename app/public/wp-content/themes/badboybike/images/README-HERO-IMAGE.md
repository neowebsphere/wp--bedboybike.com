# Hero Image Setup Instructions

## 📸 How to Add Hero Background Images

### Method 1: Using WordPress Featured Image (Recommended)

1. **Login to WordPress Admin**
   - Go to: `http://your-site.com/wp-admin`

2. **Edit Motorcycle Post**
   - Navigate to: **Posts** → **Motorcycles** (or your custom post type)
   - Click on the motorcycle you want to edit

3. **Set Featured Image**
   - Look for **"Featured Image"** in the right sidebar
   - Click **"Set featured image"**
   - Upload a new image or choose from Media Library
   - Click **"Set featured image"**

4. **Save Changes**
   - Click **"Update"** or **"Publish"**

---

### Method 2: Using Default Fallback Image

If no Featured Image is set, the system will automatically use:
```
/images/default-motorcycle-hero.jpg
```

**To add a default image:**

1. Place your image file in this folder (`/images/`)
2. Name it: `default-motorcycle-hero.jpg`
3. The image will appear automatically for all motorcycles without a Featured Image

---

## 🎨 Image Specifications

### Recommended Settings:
- **Resolution**: 1920x1080px (Full HD) or higher
- **Aspect Ratio**: 16:9 (landscape)
- **Format**: JPG (recommended) or PNG
- **File Size**: 300KB - 800KB (optimized for web)
- **Color Profile**: sRGB

### Composition Tips:
- ✅ Center the motorcycle or use rule of thirds
- ✅ Use good lighting - golden hour shots work great
- ✅ Clean, uncluttered background
- ✅ High contrast between bike and background
- ✅ Sharp focus on the motorcycle

### What to Avoid:
- ❌ Blurry or low-resolution images
- ❌ Vertical/portrait orientation
- ❌ Watermarks or text overlays
- ❌ Files larger than 2MB (slow loading)

---

## 🛠️ Quick Tips

### Optimize Images Before Upload:
Use tools like:
- [TinyPNG](https://tinypng.com/) - Free online compression
- [Squoosh](https://squoosh.app/) - Google's image optimizer
- Photoshop: "Save for Web" option

### Batch Processing:
If you have multiple motorcycle images:
1. Resize all to 1920x1080px
2. Compress to reduce file size
3. Name them descriptively (e.g., `harley-softail-2023.jpg`)
4. Upload to WordPress Media Library
5. Assign to respective motorcycles

---

## 🎯 Current Setup

The hero section automatically:
- ✅ Uses the Featured Image from WordPress
- ✅ Falls back to `default-motorcycle-hero.jpg` if none is set
- ✅ Applies parallax scrolling effect
- ✅ Adds a dark gradient overlay for better text readability
- ✅ Is fully responsive across all devices

---

## 📁 File Structure

```
/wp-content/themes/badboybike/images/
├── default-motorcycle-hero.jpg  ← Place your default hero image here
├── bikes/                       ← Individual bike photos
│   ├── bike-01/
│   ├── bike-02/
│   └── ...
└── README-HERO-IMAGE.md         ← This file
```

---

## ❓ Troubleshooting

**Problem**: Image not showing
- ✅ Check file name is exactly: `default-motorcycle-hero.jpg`
- ✅ Verify image is in `/images/` folder
- ✅ Clear WordPress cache
- ✅ Check file permissions (should be 644)

**Problem**: Image looks stretched
- ✅ Use 16:9 aspect ratio
- ✅ Minimum width: 1920px

**Problem**: Slow loading
- ✅ Compress image (under 800KB)
- ✅ Use JPG instead of PNG for photos
- ✅ Consider WebP format for modern browsers

---

Need help? Check the theme documentation or contact support.

