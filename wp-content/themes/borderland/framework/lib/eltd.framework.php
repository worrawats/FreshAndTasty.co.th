<?php
/*
   Class: ElatedFramework
   A class that initializes Elated Framework
*/
class ElatedFramework {

    private static $instance;
    public $eltdOptions;
    public $eltdMetaBoxes;
    private $skin;

    private function __construct() {
        $this->eltdOptions = ElatedOptions::get_instance();
        $this->eltdMetaBoxes = ElatedMetaBoxes::get_instance();
    }
    
    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;

    }

    public function getSkin() {
        return $this->skin;
    }

	public function setSkin(ElatedSkinAbstract $skinObject) {
		$this->skin = $skinObject;
	}
}

class ElatedSkinManager {
    private $skin;

    public function __construct() {
        $this->setSkin();
    }

    private function setSkin($skinName = 'elated') {
        if($skinName !== '') {
            if(file_exists(get_template_directory().'/framework/admin/skins/'.$skinName.'/skin.php')) {
                require_once get_template_directory().'/framework/admin/skins/'.$skinName.'/skin.php';

                $skinName = ucfirst($skinName).'Skin';

                $this->skin = new $skinName();
            }
        } else {
            $this->skin = false;
        }
    }

    public function getSkin() {
        if(empty($this->skin)) {
            $this->setSkin();
        }

        return $this->skin;
    }
}

abstract class ElatedSkinAbstract {
	protected $skinName;
    protected $styles;
    protected $scripts;
	protected $icons;
	protected $itemPosition;

	public function __toString() {
		return $this->skinName;
	}

	public function getSkinName() {
		return $this->skinName;
	}

    public function loadTemplatePart($template, $params = array()) {
        if(is_array($params) && count($params)) {
            extract($params);
        }

        if($template !== '') {
            include(locate_template('framework/admin/skins/'.$this->skinName.'/templates/'.$template.'.php'));
        }
    }

    public function enqueueScripts() {
        if(is_array($this->scripts) && count($this->scripts)) {
            foreach ($this->scripts as $scriptHandle => $scriptPath) {
                wp_enqueue_script($scriptHandle);
            }
        }
    }

    public function enqueueStyles() {
        if(is_array($this->styles) && count($this->styles)) {
            foreach ($this->styles as $styleHandle => $stylePath) {
                wp_enqueue_style($styleHandle);
            }
        }
    }

	public function getMenuIcon($icon) {
		if($icon !== '' && array_key_exists($icon, $this->icons)) {
			return $this->icons[$icon];
		}

		return ELTD_ROOT.'/img/favicon.ico';
	}

	public function getMenuItemPosition($itemPosition) {
		if($itemPosition !== '' && array_key_exists($itemPosition, $this->itemPosition)) {
			return $this->itemPosition[$itemPosition];
		}

		return 4;
	}

	public function setShortcodeJSParams() { ?>
		<script>
			window.eltdSCIcon = '<?php echo eltd_get_skin_uri().'/assets/img/admin-logo-icon.png'; ?>';
			window.eltdSCLabel = '<?php echo esc_html(ucfirst($this->skinName)); ?> Shortcodes';
		</script>
	<?php }

	public function getSkinLabel() {
		return ucfirst($this->skinName);
	}

    public function getSkinURI() {
        return get_template_directory_uri().'/framework/admin/skins/'.$this->skinName;
    }

    public abstract function renderOptions();
	public abstract function renderImport();
    public abstract function registerScripts();
    public abstract function registerStyles();
	public abstract function setIcons();
}



/*
   Class: ElatedOptions
   A class that initializes Elated Options
*/
class ElatedOptions {

    private static $instance;
    public $adminPages;
    public $options;

    private function __construct() {
        $this->adminPages = array();
        $this->options = array();
    }
    
		public static function get_instance() {
		
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
		
			return self::$instance;
		
		}

    public function addAdminPage($key, $page) {
        $this->adminPages[$key] = $page;
    }

    public function getAdminPage($key) {
        return $this->adminPages[$key];
    }

    public function getAdminPageFromSlug($slug) {
			foreach ($this->adminPages as $key=>$page ) {
				if ($page->slug == $slug)
					return $page;
			}
      return;
    }

    public function addOption($key, $value) {
        $this->options[$key] = $value;
    }

    public function getOption($key) {
			if(isset($this->options[$key]))
        return $this->options[$key];
      return;
    }
}

/*
   Class: ElatedAdminPage
   A class that initializes Elated Admin Page
*/
class ElatedAdminPage implements iLayoutNode {

    public $layout;
    private $factory;
    public $slug;
    public $title;
    public $icon;

    function __construct($slug="", $title="", $icon = "") {
        $this->layout = array();
        $this->factory = new ElatedFieldFactory();
        $this->slug = $slug;
        $this->title = $title;
        $this->icon = $icon;
    }

    public function hasChidren() {
        return (count($this->layout) > 0)?true:false;
    }

    public function getChild($key) {
        return $this->layout[$key];
    }

    public function addChild($key, $value) {
        $this->layout[$key] = $value;
    }

    function render() {
        foreach ($this->layout as $child) {
            $this->renderChild($child);
        }
    }

    public function renderChild(iRender $child) {
        $child->render($this->factory);
    }
}

/*
   Class: ElatedMetaBoxes
   A class that initializes Elated Meta Boxes
*/
class ElatedMetaBoxes {

    private static $instance;
    public $metaBoxes;
    public $options;

    private function __construct() {
        $this->metaBoxes = array();
        $this->options = array();
    }
    
		public static function get_instance() {
		
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
		
			return self::$instance;
		
		}

    public function addMetaBox($key, $box) {
        $this->metaBoxes[$key] = $box;
    }

    public function getMetaBox($key) {
        return $this->metaBoxes[$key];
    }

    public function addOption($key, $value) {
        $this->options[$key] = $value;
    }

    public function getOption($key) {
			if(isset($this->options[$key]))
        return $this->options[$key];
      return;
    }
}

/*
   Class: ElatedMetaBox
   A class that initializes Elated Meta Box
*/
class ElatedMetaBox implements iLayoutNode {

    public $layout;
	private $factory;
	public $scope;
	public $title;
	public $hidden_property;
	public $hidden_values = array();

    function __construct($scope="", $title="",$hidden_property="", $hidden_values = array()) {
        $this->layout = array();
		$this->factory = new ElatedFieldFactory();
		$this->scope = $scope;
		$this->title = $this->setTitle($title);
		$this->hidden_property = $hidden_property;
		$this->hidden_values = $hidden_values;
    }

    public function hasChidren() {
        return (count($this->layout) > 0)?true:false;
    }

    public function getChild($key) {
        return $this->layout[$key];
    }

    public function addChild($key, $value) {
        $this->layout[$key] = $value;
    }

    function render() {
        foreach ($this->layout as $child) {
            $this->renderChild($child);
        }
    }

    public function renderChild(iRender $child) {
        $child->render($this->factory);
    }

	public function setTitle($label) {
		global $eltdFramework;

		return $eltdFramework->getSkin()->getSkinLabel().' '.$label;
 	}
}

global $eltdFramework;

$eltdFramework = ElatedFramework::get_instance();
$eltdSkinManager = new ElatedSkinManager();
$eltdFramework->setSkin($eltdSkinManager->getSkin());