# Events Feature Documentation

## Overview
The Events feature has been successfully implemented in your ForceX WordPress theme. This includes a custom post type for events, admin interface, and frontend display with filtering capabilities.

## Features Implemented

### 1. Custom Post Type
- **Post Type**: `event`
- **Slug**: `/events/`
- **Admin Menu**: Events (with calendar icon)
- **Supports**: Title, Editor, Featured Image, Excerpt

### 2. Event Fields
- **Event Type**: Exhibitions, Conferences, Trade Shows, Webinars
- **Location**: Text field for event location
- **Event Date**: Date picker for event date
- **Speakers/Attendees**: Comma-separated list of speaker names
- **Registration URL**: URL for event registration

### 3. Admin Interface
- Custom meta box for event details
- Sortable columns in events list
- Custom columns showing event type, location, and date
- Proper data validation and sanitization

### 4. Frontend Templates
- **Archive Template**: `archive-event.php` - Shows all events with filters
- **Single Template**: `single-event.php` - Individual event detail page
- **Responsive Design**: Mobile-friendly layout

### 5. Filtering System
- Filter buttons: All, Exhibitions, Conferences, Trade Shows, Webinars
- JavaScript-powered client-side filtering
- Smooth animations and transitions
- "No events" message when no results found

### 6. Styling
- Matches the design provided in the image
- Event cards with hover effects
- Color-coded event type badges
- Responsive grid layout
- Professional typography and spacing

## How to Use

### Adding Events
1. Go to WordPress Admin → Events → Add New Event
2. Fill in the event title and description
3. Set a featured image
4. Configure event details in the "Event Details" meta box:
   - Select event type
   - Enter location
   - Set event date
   - Add speaker names (comma-separated)
   - Add registration URL
5. Publish the event

### Viewing Events
- **All Events**: Visit `/events/` on your website
- **Individual Event**: Click on any event card to view details
- **Filtering**: Use the filter buttons to show specific event types

### Customization
- **Colors**: Modify the event type badge colors in `src/main.css`
- **Layout**: Adjust grid columns in the CSS classes
- **Fields**: Add new fields by modifying the meta box functions in `functions.php`

## File Structure
```
├── functions.php (Custom post type and admin functions)
├── archive-event.php (Events listing page)
├── single-event.php (Individual event page)
├── src/main.css (Event-specific styles)
└── src/main.js (Filter functionality)
```

## Technical Notes
- Events are ordered by date (upcoming events first)
- Past events are filtered out by default
- All data is properly sanitized and escaped
- Responsive design works on all screen sizes
- SEO-friendly URLs and structure

## Next Steps
1. Add some sample events to test the functionality
2. Customize colors and styling to match your brand
3. Consider adding more event fields if needed
4. Set up proper permalinks (Settings → Permalinks → Save Changes)

The Events feature is now fully functional and ready to use!

