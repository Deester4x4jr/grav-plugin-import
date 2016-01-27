<?php
	namespace Grav\Plugin;

	// use Grav\Common\Page\Collection;
	use Grav\Common\Plugin;
	use Symfony\Component\Yaml\Yaml;
	// use Grav\Common\Uri;
	// use Grav\Common\Taxonomy;

	class ImportPlugin extends Plugin
	{
		public static function getSubscribedEvents() {
		    return [
		        'onPageContentRaw' => ['onPageContentRaw', 0],
		    ];
		}

		public function onPageContentRaw()
		{
			$page = $this->grav['page'];

			if (property_exists($page->header(),'imports')) {

				$path = $page->path();
				$imports = $page->header()->imports;
                $parsed = [];
				
				if (is_array($imports)) {

					foreach ($imports as $import) {
                        $yamlName = rtrim($import,'.yaml');
                        $parsed[$yamlName] = Yaml::parse(file_get_contents($path.'/'.$import));
					}
				} else {
					$parsed = Yaml::parse(file_get_contents($path.'/'.$imports));
				}

                $page->header()->imports = $parsed;
			}
		}

	}