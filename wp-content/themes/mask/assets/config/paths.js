var paths = {};

//Directory Locations
paths.siteDir			=	'localhost/mask';	//Static site! 

//Asset File Locations
paths.sassFiles = './assets/css';
paths.jsFiles     = './assets/js';
paths.imageFiles  = './assets/source';

//GLOB Patterns by File Type
paths.sassPattern     = '/**/*.scss';
paths.jsPattern       = '/**/*.js';
paths.imagePattern    = '/**/*.+(jpg|JPG|jpeg|JPEG|png|PNG|svg|SVG|gif|GIF|webp|WEBP|tif|TIF)';

//Asset File GLOBs
paths.imageFilesGlob = paths.imageFiles + paths.imagePattern;

module.exports = paths;