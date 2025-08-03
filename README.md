# Today's News Website

A modern news website with admin dashboard functionality for managing content and Arad sections.

## 🚀 Features

### Main Website
- **Responsive Design**: Modern, mobile-friendly layout
- **News Categories**: Government jobs, technology, health, entertainment, education
- **Search Functionality**: Find posts by keywords
- **Dark Mode**: Toggle between light and dark themes
- **Arad Sections**: Light blue containers for special content areas
- **No Cookie Notices**: Clean user experience without cookie popups

### Admin Dashboard
- **Modern UI**: Beautiful gradient design with glassmorphism effects
- **Post Management**: Create, edit, delete, and manage blog posts
- **Arad Section Management**: Update content for special sections
- **Website Settings**: Configure site title, description, and admin email
- **Statistics**: View website analytics and post statistics
- **Responsive**: Works on desktop, tablet, and mobile devices

## 📁 File Structure

```
today news/
├── index.html              # Main website
├── dashboard.html          # Admin dashboard
├── api/
│   └── dashboard.php       # Backend API for dashboard
├── data/                   # Data storage (auto-created)
│   ├── posts.json         # Blog posts data
│   ├── arad.json          # Arad sections data
│   └── settings.json      # Website settings
├── js/
│   ├── cookienotice.js    # Cookie notice script (disabled)
│   └── 2422103421-widgets.js
├── images/
│   ├── favicon.ico
│   └── WhatsApp-Sm.png
└── fonts/                  # Custom fonts
```

## 🔧 Changes Made

### 1. Branding Updates
- ✅ Replaced "Dr Health 24x7" with "Today's News" throughout the website
- ✅ Updated all meta tags, titles, and descriptions
- ✅ Changed canonical URLs to todaysnews.com
- ✅ Updated footer branding

### 2. Cookie Notice Removal
- ✅ Removed cookie consent popup
- ✅ Disabled cookienotice.js script
- ✅ Clean user experience without cookie interruptions

### 3. Arad Sections
- ✅ Added light blue containers with dashed borders
- ✅ Placeholder content indicating "Arad content will appear here"
- ✅ Two sections added to main page
- ✅ Admin dashboard integration for managing Arad content

### 4. Admin Dashboard
- ✅ Modern, responsive design with gradient backgrounds
- ✅ Sidebar navigation with icons
- ✅ Dashboard overview with statistics
- ✅ Post management (CRUD operations)
- ✅ Arad section management
- ✅ Website settings configuration
- ✅ Modal dialogs for editing
- ✅ Mobile-responsive layout

### 5. Backend API
- ✅ PHP-based REST API
- ✅ File-based data storage (JSON)
- ✅ CRUD operations for posts
- ✅ Arad section management
- ✅ Settings management
- ✅ Statistics calculation

## 🛠️ Installation & Setup

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4 or higher
- Modern web browser

### Setup Instructions

1. **Upload Files**
   ```bash
   # Upload all files to your web server
   # Ensure proper file permissions (755 for directories, 644 for files)
   ```

2. **Configure Web Server**
   ```apache
   # Apache .htaccess (optional)
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^api/(.*)$ api/dashboard.php [QSA,L]
   ```

3. **Set Permissions**
   ```bash
   chmod 755 data/
   chmod 644 data/*.json
   ```

4. **Access the Website**
   - Main website: `http://yourdomain.com/index.html`
   - Admin dashboard: `http://yourdomain.com/dashboard.html`

## 📖 Usage Guide

### For Website Visitors
1. **Browse News**: Navigate through different categories
2. **Search**: Use the search bar to find specific content
3. **Dark Mode**: Toggle dark/light theme using the moon icon
4. **Mobile**: Responsive design works on all devices

### For Administrators
1. **Access Dashboard**: Click "Admin Dashboard" in the header menu
2. **Manage Posts**:
   - View all posts in the "Manage Posts" section
   - Add new posts using the "Add New Post" form
   - Edit existing posts using the edit modal
   - Delete posts with confirmation
3. **Manage Arad Sections**:
   - Go to "Arad Sections" in the dashboard
   - Update content for both sections
   - Save changes to update the main website
4. **Configure Settings**:
   - Update site title and description
   - Change admin email
   - Save settings to apply changes

## 🔌 API Endpoints

### Posts Management
- `GET /api/dashboard.php?action=posts` - Get all posts
- `GET /api/dashboard.php?action=post&id={id}` - Get specific post
- `POST /api/dashboard.php?action=posts` - Create new post
- `PUT /api/dashboard.php?action=posts&id={id}` - Update post
- `DELETE /api/dashboard.php?action=posts&id={id}` - Delete post

### Arad Sections
- `GET /api/dashboard.php?action=arad` - Get Arad sections
- `PUT /api/dashboard.php?action=arad` - Update Arad sections

### Settings
- `GET /api/dashboard.php?action=settings` - Get settings
- `PUT /api/dashboard.php?action=settings` - Update settings

### Statistics
- `GET /api/dashboard.php?action=stats` - Get dashboard statistics

## 🎨 Customization

### Styling
- Main website styles are in `index.html` (CSS section)
- Dashboard styles are in `dashboard.html` (CSS section)
- Arad containers use `.arad-container` class

### Content
- Posts are stored in `data/posts.json`
- Arad sections in `data/arad.json`
- Settings in `data/settings.json`

### Adding New Features
1. **New Post Categories**: Update the select options in dashboard.html
2. **Additional Arad Sections**: Add new containers and update the API
3. **Custom Styling**: Modify CSS variables in the style sections

## 🔒 Security Considerations

### Current Implementation
- File-based storage (suitable for small to medium sites)
- No authentication (add login system for production)
- Basic input validation

### Production Recommendations
1. **Add Authentication**:
   ```php
   // Add login system
   session_start();
   if (!isset($_SESSION['admin_logged_in'])) {
       header('Location: login.php');
       exit;
   }
   ```

2. **Database Storage**:
   ```sql
   -- Create database tables
   CREATE TABLE posts (
       id VARCHAR(32) PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       content TEXT NOT NULL,
       category VARCHAR(100),
       status ENUM('published', 'draft') DEFAULT 'published',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

3. **Input Sanitization**:
   ```php
   // Sanitize inputs
   $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
   $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
   ```

## 🐛 Troubleshooting

### Common Issues

1. **Dashboard Not Loading**
   - Check PHP is enabled on your server
   - Verify file permissions
   - Check browser console for JavaScript errors

2. **API Errors**
   - Ensure `data/` directory exists and is writable
   - Check PHP error logs
   - Verify JSON file permissions

3. **Arad Sections Not Updating**
   - Check API endpoint is accessible
   - Verify JSON file is writable
   - Clear browser cache

### Debug Mode
Add this to the top of `dashboard.php` for debugging:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📱 Browser Support

- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 12+
- ✅ Edge 79+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 📞 Support

For support and questions:
- Email: admin@todaysnews.com
- Create an issue in the repository
- Check the troubleshooting section above

---

<<<<<<< HEAD
**Note**: This is a demo implementation. For production use, implement proper authentication, database storage, and security measures. 
=======
**Note**: This is a demo implementation. For production use, implement proper authentication, database storage, and security measures. 
>>>>>>> 2e6698e (new update with dashbord)
