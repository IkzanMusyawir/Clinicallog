# ClinicalLog Frontend Styling System

## Overview

ClinicalLog uses a **hybrid styling approach** combining:
1. **Tailwind CSS v3** for utility-first styling (primarily in admin dashboard and Blade components)
2. **Custom CSS design system** (`clinicallog.css`) with CSS custom properties, glassmorphism effects, and component-level styles
3. **PostCSS + Autoprefixer** pipeline via Vite for asset processing

The system targets a **light, clean SaaS aesthetic** with white-dominant backgrounds, blue-cyan accent gradients, and frosted-glass UI elements.

---

## Architecture & Stack

### Build Pipeline
- **Vite** (`vite.config.js`) processes `resources/css/app.css` and `resources/js/app.js`
- **PostCSS** (`postcss.config.js`) runs Tailwind CSS and Autoprefixer plugins
- **Tailwind CSS v3** configured via `tailwind.config.js` with `@tailwindcss/forms` plugin
- Output CSS is compiled to `public/build/` during production builds

### Dual CSS Strategy
The project maintains two parallel CSS approaches:

1. **Tailwind Utility Classes**: Used in Blade component files (`resources/views/components/*.blade.php`) and some admin views. The default Laravel Breeze component classes are present but largely superseded by custom styles.

2. **Custom Design System** (`clinicallog.css`): A comprehensive 740+ line stylesheet that defines:
   - CSS custom property tokens
   - Component-level class selectors (`.btn-primary`, `.glass-card`, `.feature-card`, etc.)
   - Layout grids and responsive breakpoints
   - Animation keyframes and transitions
   - Admin dashboard sidebar/navigation styles

### Font System
- **Primary font**: Inter (loaded from Google Fonts with weights 300–900)
- **Tailwind config override**: Extends `fontFamily.sans` to use Figtree as fallback
- **Actual usage**: Templates explicitly load Inter; the Tailwind font extension is not actively used in practice

---

## Design Tokens

Defined in `:root` of `clinicallog.css`:

| Token | Value | Purpose |
|-------|-------|---------|
| `--bg-base` | `#f8fafc` | Page background (slate-50) |
| `--bg-mid` | `#ffffff` | Card/surface backgrounds |
| `--blue` | `#1d4ed8` | Primary text/buttons |
| `--blue-lt` | `#3b82f6` | Active/hover states |
| `--cyan` | `#0891b2` | Accent color |
| `--cyan-lt` | `#06b6d4` | Bright accent |
| `--text-primary` | `#0f172a` | High-contrast headings |
| `--text-muted` | `#475569` | Body text |
| `--text-dim` | `#64748b` | Captions/labels |
| `--glass-border` | `rgba(15,23,42,.08)` | Subtle borders |
| `--glass-shadow` | Multi-layer shadow | Card elevation |
| `--r-card` | `20px` | Standard card radius |
| `--r-lg` | `28px` | Large element radius |

---

## Key Styling Patterns

### Glassmorphism
Three glass utility classes provide frosted-glass effects:
- `.glass` — Full blur (20px) with saturation boost
- `.glass-sm` — Lighter blur (12px) for subtle overlays
- `.glass-strong` — Maximum blur (32px) for prominent surfaces

All use `backdrop-filter` with semi-transparent white backgrounds and soft dark borders.

### Gradient System
- **Text gradients**: `.gradient-text` (blue-to-cyan), `.gradient-text-warm` (indigo-to-blue)
- **Button gradients**: `.btn-primary` uses linear gradient from `#2563eb` to `#0891b2`
- **CTA banner**: Full-section gradient background with radial glow overlay

### Component Classes
The stylesheet defines semantic component classes rather than relying solely on utilities:
- `.btn-primary`, `.btn-secondary` — Action buttons with hover lift effects
- `.feature-card`, `.benefit-card`, `.testi-card`, `.pricing-card` — Content cards with consistent hover transforms
- `.navbar`, `.navbar-inner` — Fixed header with scroll-state styling
- `.admin-sidebar`, `.admin-nav-link` — Dashboard navigation
- `.form-input`, `.form-label` — Form element styling
- `.glass-card` — Generic card container for admin views

### Background Orbs
Decorative blurred circles (`.orb-1` through `.orb-4`) positioned fixed behind content create ambient depth. They use low opacity (0.08) with large blur radii (100px).

---

## Responsive Strategy

Breakpoints are defined inline via `@media` queries in `clinicallog.css`:
- **1023px**: Tablet breakpoint — collapses multi-column grids to 2 columns, hides desktop nav
- **640px**: Mobile breakpoint — single-column layouts, reduced padding

Grid systems use CSS Grid with `repeat()` patterns that adapt:
- Features: 3 → 2 → 1 columns
- Benefits: 4 → 2 → 1 columns
- Steps: 4 → 2 → 1 columns
- Pricing: 3 → 1 column (centered)
- Footer: 5 → 2 → 1 columns

---

## Layout Templates

### Public Layout (`layouts/app.blade.php`)
- Loads `clinicallog.css` directly via `<link>` tag (not through Vite)
- Includes decorative orbs, fixed navbar, footer
- Uses AOS (Animate On Scroll) library for reveal animations
- Inline styles used sparingly for modal positioning

### Admin Layout (`layouts/admin.blade.php`)
- Also loads `clinicallog.css` directly
- Includes Tailwind CDN (`cdn.tailwindcss.com`) for utility classes alongside custom styles
- Fixed sidebar (260px width) with mobile slide-out behavior
- Lucide icons loaded via CDN

---

## Rules for Developers

1. **Primary stylesheet**: All new component styles should be added to `resources/css/clinicallog.css` (source) which is copied to `public/css/clinicallog.css` (served). Do not create new CSS files.

2. **Use design tokens**: Reference CSS custom properties (`--bg-base`, `--text-primary`, etc.) instead of hardcoding colors. This ensures consistency and enables future theme changes.

3. **Glassmorphism convention**: Use `.glass`, `.glass-sm`, or `.glass-strong` classes for elevated surfaces. Do not manually replicate backdrop-filter values.

4. **Component classes over utilities**: Prefer semantic classes like `.btn-primary`, `.feature-card` over assembling equivalent styles with Tailwind utilities. The custom CSS provides complete component definitions.

5. **Responsive grids**: Follow the existing grid pattern — define base columns for desktop, then use `@media(max-width:1023px)` and `@media(max-width:640px)` to reduce column counts.

6. **Animation consistency**: Use the established transition duration of `.25s` to `.3s` for hover effects. The `.reveal` class with AOS handles scroll-triggered animations.

7. **Admin vs public styling**: Admin views may mix Tailwind CDN utilities with custom classes. Public landing page relies entirely on `clinicallog.css` classes.

8. **Font loading**: Inter is loaded from Google Fonts in each layout template. Do not add additional font families without updating all templates consistently.

9. **Z-index layering**: Background orbs use `z-index: 0`, content sections use `z-index: 1`, navbar uses `z-index: 100`, modals use `z-index: 99999`. Maintain this hierarchy.

10. **Avoid inline styles**: Except for dynamic/modal positioning, prefer CSS classes. The codebase has significant inline style usage in modals and admin flash messages — this is a known inconsistency to minimize going forward.