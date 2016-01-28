<?php
	namespace Grav\Plugin;

	use Grav\Common\Plugin;
	use Symfony\Component\Yaml\Yaml;

	class ImportPlugin extends Plugin
	{
		public static function getSubscribedEvents() {
		    return [
		        'onPageInitialized' => ['onPageInitialized', 0],
		    ];
		}

		public function onPageInitialized()
		{
			if (property_exists($this->grav['page']->header(),'imports')) {

				$path = $this->grav['page']->path();
				$imports = $this->grav['page']->header()->imports;
                $parsed = [];
				
				if (is_array($imports)) {

					foreach ($imports as $import) {
                        $yamlName = rtrim($import,'.yaml');
                        $parsed[$yamlName] = Yaml::parse(file_get_contents($path.'/'.$import));
					}
				} else {
					$parsed = Yaml::parse(file_get_contents($path.'/'.$imports));
				}

                $this->grav['page']->header()->imports = $parsed;
			}
		}

	}