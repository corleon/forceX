# Favicon assets (theme fallback)

These files are used only when **no Site Icon** is set in WordPress  
(**Appearance → Customize → Site Identity → Site Icon**).

## Required files (put in this folder)

| File                 | Size     | Purpose                    |
|----------------------|----------|----------------------------|
| `favicon.ico`        | 32×32    | Classic browser favicon    |
| `favicon-32x32.png`  | 32×32    | Modern browsers            |
| `favicon-16x16.png`  | 16×16    | Tabs, bookmarks            |
| `apple-touch-icon.png` | 180×180 | iOS home screen, Safari   |

## Generate all from one image

**Option A – Recommended (one upload, all files):**
- **https://realfavicongenerator.net**  
  Upload one image (recommended **512×512 px**, square PNG).  
  Download the generated package and copy the files above into this folder.

**Option B:**
- **https://favicon.io**  
  Use “Image” mode, upload a 512×512 (or 260×260) PNG; download and copy the needed files here.

**Option C – Use WordPress only (no files here):**  
In **Appearance → Customize → Site Identity → Site Icon**, upload a single image (at least **512×512 px**). WordPress will generate and serve all favicon sizes; the theme will not use this folder.

## Source image tips

- One square image, **512×512 px** (or 260×260 minimum).
- PNG with transparency, or simple design that works on light/dark.
- Avoid tiny text; keep the icon recognizable at 16×16.
