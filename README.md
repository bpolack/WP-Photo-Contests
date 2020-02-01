# WP Siema Slider

Wordpress plugin that implements siema slider via shortcode. Uses a custom post type + taxonomy to create each slide. Each slide in a slider is maintained at equal heights using javascript. Supports SEO friendly image backgrounds and custom html content.

## Installation

1. Download zip file of latest release
2. Install plugin in Wordpress (Tested with up to WP 5.3.2)

## Plugin Usage

1. Create new slides in Wordpress using the "Siema Sliders" post type
2. Upload a feature image for use as a background image
3. Add content to slides using the Wordpress content editor
4. Categorize slides using the "Slider Category" taxonomy to group for frontend display
5. Create your slider using the below shortcode and optional attributes wherever you like on your website

Shortcode template:
```
[wp_siema_slider slider_category_slug="category-slug" numresults=8 orderby="title" order="ASC"]
```

### Prerequisites

Wordpress is required

## Built With

* [Siema](https://pawelgrzybek.github.io/siema/) - Lightweight slider library

## Authors

* **[Braighton Polack](https://github.com/bpolack/)** - *Initial work and testing* 

See also the list of [contributors](https://github.com/bpolack/WP-Siema-Slider/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Thanks to Paweł Grzybek for his amazing work on the Siema slider
