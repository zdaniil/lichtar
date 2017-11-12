<?php
/**
 * Mega Filter
 */
class ControllerModuleMegaFilter extends Controller {
	
	private static $_tmp_sort_parameters = NULL;
	
	/**
	 * Lista błędów
	 *
	 * @var array
	 */
	private $error			= array();
	
	private $_name			= 'mega_filter';
	
	private $_version		= '2.0.4.4.7';
	
	private $_hasFilters	= NULL;
	
	private $_cache_dir;
	
	private $_stores_list	= NULL;
	
	private $data = array();
	
	private $_mijoshop_update = array(
		'../../mijoshop/opencart.php' => array(
			'foreach ($modules as $module) {' => array(
				'$idx=0;',
				'$idxs=array();',
				'foreach( $modules as $k => $v ) {$idxs[] = $k;}',
				'foreach ($modules as $module) {',
				'$idx++;',
			),
			'if (isset($part[0]) && self::$config->get($part[0] . \'_status\') and $part[0] == $module_name) {' => array(
				'if (isset($part[0]) && self::$config->get($part[0] . \'_status\') and $part[0] == $module_name and $part[0] != \'mega_filter\') {'
			),
			'$setting_info    = MijoShop::get(\'utility\')->getModule($part[1]);' => array(
				'$setting_info    = MijoShop::get(\'utility\')->getModule($part[1]);',
				'if( $part[0] == \'mega_filter\' ) {',
					'$setting_info = $controller->config->get( \'mega_filter_module\' );',
					'$setting_info = $setting_info[$idxs[$idx-1]];',
					'$setting_info[\'_idx\'] = $idxs[$idx-1];',
				'}'
			)
		)
	);
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->_cache_dir = DIR_SYSTEM . 'cache_mfp';
		
		$this->data['HTTP_URL'] = '';
		$this->data['action_set_tooltip'] = $this->url->link('module/' . $this->_name . '/setTooltip', 'token=' . $this->session->data['token'], 'SSL');
	
		if( class_exists( 'MijoShop' ) ) {
			$this->data['HTTP_URL'] = HTTP_CATALOG . 'opencart/admin/';
		}
	}
	
	private function hasFilters() {
		if( $this->_hasFilters === NULL ) {
			$this->_hasFilters = version_compare( VERSION, '1.5.5', '>=' );
		}
		
		return $this->_hasFilters;
	}
	
	private function _cacheWritable() {
		return ! is_dir( $this->_cache_dir ) || ! is_writable( $this->_cache_dir ) ? false : true;
	}

	/**
	 * Inicjuj
	 */
	private function _init( $tab ) {
		// załaduj język
		$this->data = array_merge($this->data, $this->language->load('module/' . $this->_name));
		
		// aktywna zakładka
		$this->data['tab_active'] = $tab;
		
		// linki zakładek
		$this->data['tab_layout_link']		= $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_attributes_link']	= $this->url->link('module/' . $this->_name . '/attributes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_options_link']		= $this->url->link('module/' . $this->_name . '/options', 'token=' . $this->session->data['token'], 'SSL');
		
		if( $this->hasFilters() ) {
			$this->data['tab_filters_link']		= $this->url->link('module/' . $this->_name . '/filters', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->data['tab_settings_link']	= $this->url->link('module/' . $this->_name . '/settings', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_seo_link']	= $this->url->link('module/' . $this->_name . '/seo', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_about_link']		= $this->url->link('module/' . $this->_name . '/about', 'token=' . $this->session->data['token'], 'SSL');
		
		// linki
		$this->data['action']	= $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['back']		= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['_name']	= $this->_name;
		
		// okruszki
		$this->data['breadcrumbs'] = array();
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		// tytuł
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->_messages();
		
		$curr_ver = $this->config->get('mfilter_version');
		
		// instalacja/aktualizacja
		if( ! $curr_ver || version_compare( $curr_ver, $this->_version, '<' ) || $this->_isOldMFilterPlus() ) {			
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			$stores = array(0);
			
			foreach( $this->model_setting_store->getStores() as $row ) {
				$stores[] = $row['store_id'];
			}
			
			// if update
			if( $curr_ver ) {
				// @since 2.0.4.4.5.2
				$this->_updateDB();
			
				// @since 1.2.9.2
				if( $this->_writableCss() ) {						
					$this->_updateCss();
				}
			}
			////////////////////////////////////////////////////////////////////
			
			// @since 2.0.3.2
			$this->db->query("
				CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mfilter_url_alias` (
					`mfilter_url_alias_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
					`path` TEXT NOT NULL,
					`mfp` TEXT NOT NULL,
					`alias` TEXT NOT NULL,
					`language_id` INT(11) NOT NULL,
					`store_id` INT(11) NOT NULL DEFAULT '0',
					PRIMARY KEY(`mfilter_url_alias_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
			");
			
			// Change column 'value' in table 'setting' from 'text' to 'longtext'
			$query = $this->db->query( "
				SELECT 
					* 
				FROM 
					INFORMATION_SCHEMA.COLUMNS 
				WHERE 
					TABLE_SCHEMA LIKE '" . $this->db->escape( DB_DATABASE ) . "' AND
					TABLE_NAME LIKE '" . $this->db->escape( DB_PREFIX . 'setting' ) . "' AND 
					COLUMN_NAME LIKE 'value'
			");
			
			if( $query->num_rows && isset( $query->row['COLUMN_TYPE'] ) && strtolower( $query->row['COLUMN_TYPE'] ) != 'longtext' ) {
				$sql = array();
				$sql[] = 'ALTER TABLE `' . DB_PREFIX . 'setting` CHANGE `value` `value` LONGTEXT';
				
				if( ! empty( $query->row['CHARACTER_SET_NAME'] ) ) {
					$sql[] = 'CHARACTER SET ' . $query->row['CHARACTER_SET_NAME'];
				}
				
				if( ! empty( $query->row['COLLATION_NAME'] ) ) {
					$sql[] = 'COLLATE ' . $query->row['COLLATION_NAME'];
				}
				
				if( ! empty( $query->row['IS_NULLABLE'] ) && strtolower( $query->row['IS_NULLABLE'] ) == 'no' ) {
					$sql[] = 'NOT';
				}
				
				$sql[] = 'NULL';
				
				$this->db->query( implode( ' ', $sql ) );
			}
			
			// dodatkowe szablony //////////////////////////////////////////////
			
			$add_routes = array(
				'Mega Filter PRO' => 'module/mega_filter/results',
				'Manufacturer info' => 'product/manufacturer/info'
			);
			
			foreach( $add_routes as $name => $route ) {
				if( ! $this->db->query( "SELECT COUNT(*) AS c FROM " . DB_PREFIX . "layout_route WHERE route LIKE '" . $this->db->escape( $route ) . "'")->row['c'] ) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name='" . $this->db->escape( $name ) . "'");
					$layout_id = $this->db->getLastId();

					foreach( $stores as $store_id ) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id='" . $layout_id . "', store_id='" . $store_id . "', route='" . $this->db->escape( $route ) . "'");
					}
				}
			}
			
			////////////////////////////////////////////////////////////////////
			
			foreach( $stores as $store_id ) {
				$this->model_setting_setting->editSetting('mfilter_version', array(
					'mfilter_version' => $this->_version
				), $store_id);
			}
			
			if( $tab != 'installprogress' ) {
				$this->_installMFilterPlus();
			}
			
			if( $curr_ver ) {
				/* @since v2.0.4.4 */
				$this->verifyLicense( $tab );
				
				if( NULL != ( $mlicense = $this->config->get( 'mfilter_license' ) ) ) {
					if( ! $this->activate( $mlicense['order_id'], $mlicense['email'] ) ) {
						$this->db->query( "DELETE FROM `" . DB_PREFIX . "setting` WHERE `key` = 'mfilter_license'" );
						
						$this->config->set( 'mfilter_license', '' );
						
						$this->response->redirect($this->url->link('module/' . $this->_name . '/license', 'token=' . $this->session->data['token'], 'SSL'));
					}
				}
				
				$this->session->data['success'] = $this->language->get('success_updated');
			
				$this->response->redirect($this->url->link('module/' . $this->_name . '/about', 'token=' . $this->session->data['token'], 'SSL'));
			}
		} else if( ! file_exists( DIR_SYSTEM . '../catalog/view/theme/default/template/module/mega_filter.tpl' ) ) {
			$this->_setErrors(array(
				'warning' => $this->language->get( 'error_missing_template_file' )
			));
		}
		
		if( is_readable( __FILE__ ) ) {
			// sprawdź czy użytkownik skopiował plik szablonu
			$files = glob( DIR_SYSTEM . '../catalog/view/theme/*/template/module/mega_filter.tpl' );
			$source = filemtime( DIR_SYSTEM . '../catalog/view/theme/default/template/module/mega_filter.tpl' );
			
			foreach( $files as $id => $file ) {
				$file = realpath( $file );
				$parts = explode( DIRECTORY_SEPARATOR, $file );
				
				array_pop( $parts ); // nazwa pliku
				array_pop( $parts ); // katalog 'module'
				array_pop( $parts ); // katalog 'template'
				
				$theme = array_pop( $parts );
				
				if( $theme == 'default' || ! is_readable( $file ) ) {
					unset( $files[$id] );
				} else {
					$time = filemtime( $file );
					
					if( $source - $time > 60 * 10 ) {
						$files[$id] = '<span style="margin-left:15px; display: inline-block;"> - /catalog/view/theme/<b>' . $theme . '</b>/template/module/mega_filter.tpl</span>';
					} else {
						unset( $files[$id] );
					}
				}
			}
			
			if( $files ) {
				$this->_setErrors(array(
					'warning' => sprintf( $this->language->get( 'error_upgrade_template_file' ), implode( '<br>', $files ) )
				));
			}
		}
		
		if( class_exists( 'MijoShop' ) && version_compare( $this->config->get('mfilter_mijoshop'), $curr_ver, '<' ) ) {
			$warnings = array();
			
			foreach( $this->_mijoshop_update as $file => $changes ) {
				$file = realpath( DIR_SYSTEM . $file );
				
				if( file_exists( $file ) && is_readable( $file ) ) {
					$tmp = NULL;
					
					if( file_exists( $file . '_backup_mf' ) ) {
						if( is_readable( $file . '_backup_mf' ) ) {
							$tmp = file_get_contents( $file . '_backup_mf' );
						} else {
							$warnings[] = sprintf( 'No permission to read the file "%s"', $file . '_backup_mf' );
						}
					} else {
						$tmp = file_get_contents( $file );
					}
					
					if( $tmp !== NULL ) {
						foreach( $changes as $search => $replace ) {
							$replace = implode( "\n", $replace );

							if( mb_strpos( $tmp, $search, 0, 'utf-8' ) !== false ) {
								$tmp = str_replace( $search, $replace, $tmp );
							} else if( mb_strpos( $tmp, $replace, 0, 'utf-8' ) === false ) {
								$warnings[] = sprintf( 'In the file "%s" not found string "%s"', $file, $search );
							}
						}
					}
					
					if( ! $warnings ) {
						if( ! is_writable( dirname( $file ) ) ) {
							$warnings[] = sprintf( 'No permission to create a copy of the file "%s" in directory "%s"', $file, dirname( $file ) );
						} else if( ! is_writable( $file ) ) {
							$warnings[] = sprintf( 'No permission to modify the file "%s"', $file );
						} else if( $tmp !== NULL ) {
							if( ! file_exists( $file . '_backup_mf' ) ) {
								copy( $file, $file . '_backup_mf' );
							}
							
							file_put_contents( $file, $tmp );
						}
					}
				}
			}
			
			if( empty( $warnings ) ) {
				$this->_saveSettings('mfilter_mijoshop', array(
					'mfilter_mijoshop' => $this->_version
				));
			} else {
				$warnings[] = 'You need to manually find and replace the following strings:';
				$warnings[] = '';
				
				foreach( $this->_mijoshop_update as $file => $changes ) {
					$file = realpath( DIR_SYSTEM . $file );
					
					foreach( $changes as $search => $replace ) {
						$warnings[] = sprintf( 'String: <pre>%s</pre> replace to: <pre>%s</pre> in file <b>%s</b>', $search, implode( "\n", $replace ), $file );
						$warnings[] = '';
					}
				}
				
				$warnings[] = sprintf( 'Remember to make backup your files! <a href="%s">Click here when you done</a>', $this->url->link('module/' . $this->_name . '/mijoshop_manually', 'token=' . $this->session->data['token'], 'SSL') );
				
				$this->_setErrors(array(
					'warning' => implode( '<br />', $warnings )
				));
			}
		}
		
		/* @since v2.0.4.4 */
		$this->verifyLicense( $tab );
		
		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');
		
		if( NULL != ( $mlicense = $this->config->get( 'mfilter_license' ) ) ) {
			if( ! file_exists( DIR_SYSTEM . 'library/mfilter_core.php' ) || strpos( file_get_contents( DIR_SYSTEM . 'library/mfilter_core.php' ), 'MegaFilterCore' ) === false ) {
				$this->_setErrors(array(
					'warning' => 'Detected missing files - please <a href="' . $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'] . '&reactivate=1', 'SSL') . '">click here</a> to fix problem',
				));
				
				if( ! empty( $this->request->get['reactivate'] ) ) {
					$this->activate( $mlicense['order_id'], $mlicense['email'] );
					
					$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}
	}
	
	/* @since v2.0.4.4 */
	private function verifyLicense( $tab ) {
		if( ! in_array( $tab, array( 'license', 'installprogress' ) ) && ! $this->config->get('mfilter_license') ) {
			$this->response->redirect($this->url->link('module/' . $this->_name . '/license', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function mijoshop_manually() {
		$this->_saveSettings('mfilter_mijoshop', array(
			'mfilter_mijoshop' => $this->_version
		));
		
		$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	private function _saveSettings( $group, $data ) {
		if( $this->_stores_list === NULL ) {
			$this->load->model('setting/store');

			$this->_stores_list = array(0);

			foreach( $this->model_setting_store->getStores() as $row ) {
				$this->_stores_list[] = $row['store_id'];
			}
		}
		
		$this->load->model('setting/setting');
		
		foreach( $this->_stores_list as $store_id ) {
			$this->model_setting_setting->editSetting($group, $data, $store_id);
		}
	}
	
	private function _hasMFilterPlus() {
		if( ! file_exists( DIR_SYSTEM . 'library/mfilter_plus.php' ) ) {
			return false;
		}
		
		return true;
	}
	
	private function _isOldMFilterPlus() {		
		if( ! $this->_hasMFilterPlus() ) {
			return false;
		}
		
		$curr_ver = $this->config->get('mfilter_plus_version');
		
		require_once DIR_SYSTEM . 'library/mfilter_plus.php';
		
		return version_compare( $curr_ver, Mfilter_Plus::getInstance( $this )->version(), '<' );
	}
	
	private function _messages() {		
		// powiadomienia
		if( isset( $this->session->data['success'] ) ) {
			$this->data['_success'] = $this->session->data['success'];
			
			unset( $this->session->data['success'] );
		}
		
		if( isset( $this->session->data['error'] ) ) {
			$this->_setErrors(array(
				'warning' => $this->session->data['error']
			));
			
			unset( $this->session->data['error'] );
		}
	}
	
	public function get_data() {
		$json = array();
		
		if( isset( $this->request->get['mf_id'] ) ) {
			$json = $this->config->get( $this->_name . '_module' );
			$json = isset( $json[$this->request->get['mf_id']] ) ? $json[$this->request->get['mf_id']] : array();
		}
		
		echo json_encode( $json );
		
		die();
	}
	
	private function _remove_data( $id ) {
		$data = $this->config->get( $this->_name . '_module' );
			
		unset( $data[$id] );
			
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting($this->_name . '_module', array( $this->_name . '_module' => $data ));
	}
	
	public function remove_data() {
		if( isset( $this->request->get['mf_id'] ) && $this->checkPermission() ) {
			$this->_remove_data( $this->request->get['mf_id'] );
		}
		
		die();
	}
	
	private function _save( & $data, & $store ) {
		foreach( $data as $k => $v ) {
			if( is_array( $v ) ) {
				$tmp = isset( $store[$k] ) ? $store[$k] : array();
				
				$this->_save( $v, $tmp );
				
				$store[$k] = $tmp;
			//} else if( isset( $store[$k] ) && is_array( $store[$k] ) ) {
			//	array_push( $store, $v );
			} else {
				$store[$k] = $v;
			}
		}
	}
	
	public function save_data() {
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$idx	= (int) $this->request->get['mf_idx'];
			$count	= (int) $this->request->get['mf_count'];
			$pager	= (bool) $this->request->get['mf_pager'];
			$mf_id	= (int) $this->request->get['mf_id'];
			
			if( ! $idx || ! isset( $this->session->data['mf_data_to_save'] ) ) {
				$settings	= $this->config->get($this->_name . '_settings' );
				
				$this->session->data['mf_data_to_save'] = array(
					'attribs'		=> (array) $this->config->get( $this->_name . '_attribs' ),
					'options'		=> (array) $this->config->get( $this->_name . '_options' ),
					'base_attribs'	=> (array) $settings['attribs'],
					'configuration'	=> array()
				);
				
				if( $this->hasFilters() ) {
					$this->session->data['mf_data_to_save']['filters'] = (array) $this->config->get( $this->_name . '_filters' );
				}
				
				if( NULL != ( $module = $this->config->get($this->_name . '_module') ) ) {
					if( isset( $module[$mf_id]['attribs'] ) ) {
						$this->session->data['mf_data_to_save']['attribs'] = $module[$mf_id]['attribs'];
					}
					
					if( isset( $module[$mf_id]['options'] ) ) {
						$this->session->data['mf_data_to_save']['options'] = $module[$mf_id]['options'];
					}
					
					if( isset( $module[$mf_id]['filters'] ) ) {
						$this->session->data['mf_data_to_save']['filters'] = $module[$mf_id]['filters'];
					}
					
					if( isset( $module[$mf_id]['base_attribs'] ) ) {
						$this->session->data['mf_data_to_save']['base_attribs'] = $module[$mf_id]['base_attribs'];
					}
					
					if( isset( $module[$mf_id]['configuration'] ) ) {
						$this->session->data['mf_data_to_save']['configuration'] = $module[$mf_id]['configuration'];
					}
				}
			}
			
			$this->_save( $this->request->post[$this->_name.'_module'], $this->session->data['mf_data_to_save'] );
			
			if( ! $pager && $idx == $count ) {				
				$settings = $this->config->get( $this->_name . '_settings' );
				
				if( empty( $this->session->data['mf_data_to_save']['layout_id'] ) ) {
					$this->session->data['mf_data_to_save']['layout_id'] = array();
				}
				
				if( ! in_array( $settings['layout_c'], $this->session->data['mf_data_to_save']['layout_id'] ) ) {
					$this->session->data['mf_data_to_save']['category_id'] = array();
				}
			
				if( empty( $this->session->data['mf_data_to_save']['store_id'] ) ) {
					$this->session->data['mf_data_to_save']['store_id'] = array( 0 );
				}
				
				if( NULL == ( $data = $this->config->get($this->_name . '_module') ) ) {
					$data = array();
				}
				
				$data[$mf_id] = $this->session->data['mf_data_to_save'];
				
				$this->db->query("
					DELETE FROM 
						`" . DB_PREFIX . "layout_module` 
					WHERE 
						`code` REGEXP '^mega_filter." . $mf_id . "$'
				");
				
				$this->db->query("
					DELETE FROM 
						`" . DB_PREFIX . "setting` 
					WHERE 
						`code` = 'mega_filter_module'
				");
				
				if( ! empty( $data[$mf_id]['layout_id'] ) ) {
					foreach( $data[$mf_id]['layout_id'] as $layout_id ) {
						$this->db->query("
							INSERT INTO 
								`" . DB_PREFIX . "layout_module` 
							SET
								`layout_id` = '" . (int)$layout_id . "',
								`code` = 'mega_filter." . (int)$mf_id . "',
								`position` = '" . $this->db->escape( $data[$mf_id]['position'] ) . "',
								`sort_order` = '" . $this->db->escape( $data[$mf_id]['sort_order'] ) . "'
						");
					}
				}
				
				$byStores = array();
				
				foreach( $data as $v ) {
					if( empty( $v['store_id'] ) ) {
						$v['store_id'] = array( 0 );
					}
					
					foreach( $v['store_id'] as $vv ) {
						$byStores[$vv] = $vv;
					}
					
					if( ! isset( $byStores[0] ) ) {
						$byStores[0] = $vv;
						$byStores[0]['store_id'] = array();
					}
				}
				
				$this->load->model('setting/setting');
				
				foreach( $byStores as $store_id ) {
					$this->model_setting_setting->editSetting(
						$this->_name . '_module', 
						array( $this->_name . '_module' => $data ),
						$store_id
					);
				}	
				
				unset( $this->session->data['mf_data_to_save'] );
				
				if( $this->_writableCss() ) {
					$this->_updateCss();
				}
				
				$this->_clearCacheByIdx( $mf_id );
			}
		}
		
		die();
	}
	
	private function _clearCacheByIdx( $idx ) {
		if( $this->_cacheWritable() && NULL != ( $files = glob($this->_cache_dir . '/idx.' . $idx . '.*') ) ) {
			foreach( $files as $file ) {
				if( strlen( basename( $file ) ) > 32 ) {
					@ unlink( $file );
				}
			}
		}
	}
	
	/**
	 * Ustawienia szablonów
	 */
	public function index() {
		$this->_init( $this->_name );
		
		// załaduj modele
		$this->load->model('design/layout');
		$this->load->model('localisation/language');
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('setting/store');
		
		$settings = $this->config->get( $this->_name . '_settings' );
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$modules = (array) $this->config->get($this->_name . '_module');
		
		ksort( $modules );
		
		$this->_setParams(array(
			'modules'		=> $modules
		), array());
		
		// parametry
		$this->data['token']		= $this->session->data['token'];
		$this->data['layouts']		= $this->model_design_layout->getLayouts();
		$this->data['languages']	= $this->model_localisation_language->getLanguages();		
		$this->data['layouts']		= $this->model_design_layout->getLayouts();
		$this->data['settings']		= $settings;
		$this->data['attribs']		= (array) $this->config->get( $this->_name . '_attribs' );
		$this->data['options']		= (array) $this->config->get($this->_name . '_options');
		$this->data['filters']		= (array) $this->config->get($this->_name . '_filters');
		$this->data['items']		= $this->_getItems();
		$this->data['optionItems']	= $this->_getOptionItems();
		
		if( $this->hasFilters() ) {
			$this->data['filterItems']	= $this->_getFilterItems();
		}
		
		// Show in Categories ////////////////////////////////////////////////////////////
		$categories_ids = array();
		
		foreach( $this->data['modules'] as $module ) {			
			if( ! empty( $module['category_id'] ) ) {
				foreach( $module['category_id'] as $category_id ) {
					$categories_ids[] = (int) $category_id;
				}
			}
			
			if( ! empty( $module['categories'] ) ) {
				foreach( $module['categories'] as $category_id ) {
					if( ! empty( $category_id['root_category_id'] ) ) {
						$categories_ids[] = (int) $category_id['root_category_id'];
					}
				}
			}
		}
		
		$this->data['categories'] = array();
		$categories = array();
		
		if( ! empty( $categories_ids ) ) {
			$categories	= array();
			
			foreach( $this->db->query( $this->_qCat( $categories_ids ) )->rows as $category ) {
				$categories[$category['category_id']] = ( $category['path'] ? $category['path'] . ' &gt; ' : '' ) . $category['name'];
			}
			
			foreach( $this->data['modules'] as $module_id => $module ) {
				if( ! empty( $module['category_id'] ) ) {				
					foreach( $module['category_id'] as $category_id ) {
						if( isset( $categories[$category_id] ) ) {
							$this->data['categories'][$module_id][$category_id] = $categories[$category_id];
						}
					}
				}
			}
		}
		
		$this->data['categoriesNames'] = $categories;
		
		// Hide in Categories ////////////////////////////////////////////////////////////
		$categories_ids = array();
		
		foreach( $this->data['modules'] as $module ) {
			if( empty( $module['hide_category_id'] ) ) continue;
			
			foreach( $module['hide_category_id'] as $category_id ) {
				$categories_ids[] = (int) $category_id;
			}
		}
		
		$this->data['hideCategories'] = array();
		
		if( ! empty( $categories_ids ) ) {
			$categories	= array();
			
			foreach( $this->db->query( $this->_qCat( $categories_ids ) )->rows as $category ) {
				$categories[$category['category_id']] = ( $category['path'] ? $category['path'] . ' &gt; ' : '' ) . $category['name'];
			}
			
			foreach( $this->data['modules'] as $module_id => $module ) {
				if( empty( $module['hide_category_id'] ) ) continue;
				
				foreach( $module['hide_category_id'] as $category_id ) {
					if( empty( $categories[$category_id] ) ) continue;
					
					$this->data['hideCategories'][$module_id][$category_id] = $categories[$category_id];
				}
			}
		}
		
		// Stores //////////////////////////////////////////////////////////////
		
		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default')
		);
				
		foreach( $this->model_setting_store->getStores() as $result ) {
			$this->data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}
		
		// Groups of customers /////////////////////////////////////////////////
		
		if( version_compare( VERSION, '2.1.0.0', '>=' ) ) {
			$this->load->model('customer/customer_group');
			
			$customerGroups = $this->model_customer_customer_group->getCustomerGroups(array());
		} else {
			$this->load->model('sale/customer_group');
			
			$customerGroups = $this->model_sale_customer_group->getCustomerGroups(array());
		}
		
		$this->data['customerGroups'] = array();
		
		foreach( $customerGroups as $result ) {
			$this->data['customerGroups'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'name' => $result['name']
			);
		}
		
		////////////////////////////////////////////////////////////////////////
		
		$this->data['action_ldv']			= $this->url->link('module/' . $this->_name . '/ldv', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_save_data']		= $this->url->link('module/' . $this->_name . '/save_data', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_get_data']		= $this->url->link('module/' . $this->_name . '/get_data', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_remove_data']	= $this->url->link('module/' . $this->_name . '/remove_data', 'token=' . $this->session->data['token'], 'SSL');
				
		$this->response->setOutput( $this->load->view('module/mega_filter.tpl', $this->data) );
	}
	
	private function _qCat( $categories_ids ) {
		return "
			SELECT 
				`c`.`category_id`, `cd`.`name`,
				" . ( $this->hasFilters() ? "
				(
					SELECT 
						GROUP_CONCAT(`cd1`.`name` ORDER BY `level` SEPARATOR ' &gt; ') 
					FROM 
						`" . DB_PREFIX . "category_path` AS `cp` 
					LEFT JOIN 
						`" . DB_PREFIX . "category_description` AS `cd1` 
					ON 
						`cp`.`path_id` = `cd1`.`category_id` AND `cp`.`category_id` != `cp`.`path_id` 
					WHERE 
						`cp`.`category_id` = `c`.`category_id` AND `cd1`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' 
					GROUP BY 
						`cp`.`category_id`
				) AS `path`" : "CONCAT( '', '' ) AS `path`" ) . "
			FROM 
				`" . DB_PREFIX . "category` AS `c`
			LEFT JOIN
				`" . DB_PREFIX . "category_description` AS `cd`
			ON
				`c`.`category_id` = `cd`.`category_id` AND `cd`.`language_id` = " . $this->config->get( 'config_language_id' ) . "
			WHERE
				`c`.`category_id` IN(" . implode( ',', array_unique( $categories_ids ) ) . ")
		";
	}
	
	public function ldv() {
		// załaduj język
		$this->data = array_merge($this->data, $this->language->load('module/' . $this->_name));
		
		$this->data['_name']	= $this->_name;
		$this->data['name']		= $this->request->get['name'];
		$this->data['type']		= $this->request->get['type'];
		$this->data['IDX']		= $this->request->get['idx'];
		
		$this->data['mfp_plus_version'] = $this->_hasMFilterPlus();
		$this->data['tagsSupport'] = $this->data['mfp_plus_version'] && version_compare( $this->config->get('mfilter_plus_version'), '1.2.2', '>=' );
		
		$filter	= isset( $this->request->get['filter'] ) ? $this->request->get['filter'] : '';
		$page	= isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;		
		$limit	= 100;//$this->config->get('config_admin_limit');
		
		switch( $this->data['type'] ) {
			case 'base_attribs' : {
				$settings	= $this->config->get($this->_name . '_settings' );
				$this->data['base_attribs'] = $settings['attribs'];
				
				break;
			}
			case 'attribs'		: $this->data['attribs']		= $this->config->get($this->_name . '_attribs'); break;
			case 'options'		: $this->data['options']		= $this->config->get($this->_name . '_options'); break;
			case 'filters'		: $this->data['filters']		= $this->config->get($this->_name . '_filters'); break;
			case 'configuration': $this->data['configuration']	= $this->config->get($this->_name . '_settings' ); break;
		}
		
		if( ! empty( $this->request->get['mf_default'] ) && $this->hasPermission() ) {
			$data = $this->config->get( $this->_name . '_module' );
			
			$data[$this->request->get['idx']][$this->data['type']] = array();

			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting($this->_name . '_module', array( $this->_name . '_module' => $data ));
		} else if( empty( $this->request->get['mf_default'] ) && NULL != ( $module = $this->config->get($this->_name . '_module' ) ) ) {
			if( isset( $module[$this->request->get['idx']] ) ) {
				$module = $module[$this->request->get['idx']];
				
				if( ! empty( $module['base_attribs'] ) ) {
					$this->data['base_attribs'] = $module['base_attribs'];
				}

				if( ! empty( $module['attribs'] ) ) {
					$this->data['attribs'] = $module['attribs'];
				}

				if( ! empty( $module['options'] ) ) {
					$this->data['options'] = $module['options'];
				}

				if( ! empty( $module['filters'] ) ) {
					$this->data['filters'] = $module['filters'];
				}
				
				if( ! empty( $module['configuration'] ) ) {
					$this->data['configuration'] = $module['configuration'];
				}
			}
		}
		
		$total = NULL;
		
		if( $this->data['type'] == 'options' ) {
			$this->data['optionItems']	= $this->_getOptionItems($limit * ( $page-1 ), $limit, $filter);
			$total = $this->_getTotalOptionItems( $filter );
		} else if( $this->hasFilters() && $this->data['type'] == 'filters' ) {
			$this->data['filterItems'] = $this->_getFilterItems($limit * ( $page-1 ), $limit, $filter);
			$total = $this->_getTotalFilterItems( $filter );
		} else if( $this->data['type'] == 'attribs' ) {
			$this->data['items']	= $this->_getItems($limit * ( $page-1 ), $limit, $filter);
			$total					= $this->_getTotalItems( $filter );
		}
		
		if( $total !== NULL ) {
			$pagination = new Pagination();
			$pagination->total = $total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('module/mega_filter/ldv', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

			$this->data['pagination'] = $pagination->render();
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_ldv.tpl', $this->data) );
	}
	
	private function _getItems( $start = NULL, $limit = NULL, $filter = NULL ) {
		$items = array();
		
		$this->load->model('catalog/attribute');
		
		foreach( $this->model_catalog_attribute->getAttributes(array( 'start' => $start, 'limit' => $limit, 'filter_name' => $filter )) as $attribute ) {
			$items[$attribute['attribute_group_id']]['name']		= $attribute['attribute_group'];
			$items[$attribute['attribute_group_id']]['childs'][]	= $attribute;
		}
		
		return $items;
	}
	
	private function _getTotalItems( $filter = NULL ) {
		$sql = "SELECT 
			COUNT(*) AS c 
			FROM 
				" . DB_PREFIX . "attribute a 
			LEFT JOIN 
				" . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) 
			WHERE 
				ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if( $filter ) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape( $filter ) . "%'";
		}
		
		return $this->db->query( $sql )->row['c'];
	}
	
	private function _getAttribIds() {
		$ids = array();
		
		$this->load->model('catalog/attribute');
		
		foreach( $this->model_catalog_attribute->getAttributes(array()) as $attribute ) {
			$ids[$attribute['attribute_id']] = $attribute['attribute_id'];
		}
		
		return $ids;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Ustawienia atrybutów 
	 */
	public function attributes() {
		$this->_init( 'attributes' );
		
		$page = isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;
		$config = $this->config->get($this->_name . '_attribs');
		$limit = 100;//$this->config->get('config_admin_limit');
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/attributes', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			if( ! empty( $this->request->post[$this->_name.'_attribs'] ) ) {
				foreach( $this->request->post[$this->_name.'_attribs'] as $id => $conf ) {
					$config[$id] = $conf;
				}
				
				$ids = $this->_getAttribIds();
				
				foreach( $config as $id_g => $conf_g ) {
					foreach( $config[$id_g]['items'] as $id => $conf ) {
						if( ! isset( $ids[$id] ) ) {
							unset( $config[$id_g]['items'][$id] );
						}
					}
					
					if( empty( $config[$id_g]['items'] ) ) {
						unset( $config[$id_g] );
					}
				}
			}
			
			// główny sklep
			$this->model_setting_setting->editSetting($this->_name . '_attribs', array( $this->_name . '_attribs' => $config ));
			
			// pozostałe sklepy			
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_attribs', array( $this->_name . '_attribs' => $config ), $result['store_id']);
			}
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/attributes', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL'));
		}
		
		$this->load->model('tool/image');
		$this->load->model('catalog/attribute_group');
		$this->load->model('localisation/language');
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$this->data['token'] = $this->session->data['token'];
		$this->data['items'] = $this->_getItems( $limit * ( $page-1 ), $limit );
		$this->data['attribs'] = $config;
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['attribGroups'] = $this->model_catalog_attribute_group->getAttributeGroups(array());
		$this->data['action_attribs_by_group'] = $this->url->link('module/' . $this->_name . '/getAttribsByGroupAsJson', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_values_by_attrib'] = $this->url->link('module/' . $this->_name . '/getAttribsValuesByAttribAsJson', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_attribs_save'] = $this->url->link('module/' . $this->_name . '/attribsSave', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_attribs_reset'] = $this->url->link('module/' . $this->_name . '/attribsReset', 'token=' . $this->session->data['token'], 'SSL');
		
		$pagination = new Pagination();
		$pagination->total = $this->model_catalog_attribute->getTotalAttributes();
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/mega_filter/attributes', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->response->setOutput( $this->load->view('module/mega_filter_attributes.tpl', $this->data) );
	}
	
	public function attribsReset() {
		if( ! empty( $this->request->post['attr_id'] ) && ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			$attr_id = (int)$this->request->post['attr_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type = (string)$this->request->post['type'];
			
			switch( $type ) {
				case 'images' : $type = 'img'; break;
				default : $type = 'sort';
			}
			
			// główny sklep
			$this->model_setting_setting->deleteSetting($this->_name . '_at_' . $type . '_' . $attr_id . '_' . $lang_id );
			
			// pozostałe sklepy			
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->deleteSetting($this->_name . '_at_' . $type . '_' . $attr_id . '_' . $lang_id, $result['store_id']);
			}	
		}
	}
	
	public function attribsSave() {
		if( ! empty( $this->request->post['attr_id'] ) && ! empty( $this->request->post['items'] ) || ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$data		= array();
			$attr_id	= (int) $this->request->post['attr_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type		= $this->request->post['type'];
			
			if( isset( $this->request->post['items'] ) ) {
				foreach( $this->request->post['items'] as $i => $v ) {
					switch( $type ) {
						case 'images' : {
							$data[$v['key']] = $v['img'];

							break;
						}
						case 'sort-values' : {
							$data[$v['key']] = $i;

							break;
						}
					}
				}
			}
			
			switch( $type ) {
				case 'images'		: 
					$type = 'img'; break;
				case 'sort-values'	: 
				default : 
					$type = 'sort'; break;
			}
			
			$key	= $this->_name . '_at_' . $type . '_' . $attr_id . '_' . $lang_id;
			$data	= array( $key => $data );
			
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			
			// główny sklep
			$this->model_setting_setting->editSetting($key, $data);
			
			// pozostałe sklepy
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($key, $data, $result['store_id']);
			}
		}
	}
	
	public function getAttribsByGroupAsJson() {
		$json = array();
		
		if( ! empty( $this->request->get['attribute_group_id'] ) ) {
			$this->load->model('catalog/attribute');
			$json = $this->model_catalog_attribute->getAttributes(array('filter_attribute_group_id'=>(int)$this->request->get['attribute_group_id']));
		}
		
		$this->response->setOutput( json_encode( $json ) );
	}
	
	public function getAttribsValuesByAttribAsJson() {
		$json = array();
		
		if( ! empty( $this->request->get['attribute_id'] ) && ! empty( $this->request->get['type'] ) && ! empty( $this->request->get['lang_id'] ) ) {
			$this->load->model('tool/image');
			
			/**
			 * Parametry 
			 */
			$attribute_id	= $this->request->get['attribute_id'];
			$lang_id		= $this->request->get['lang_id'];
			$type			= $this->request->get['type'];
			$settings		= $this->config->get( $this->_name . '_settings' );
			$attribs		= (array) $this->config->get( $this->_name . '_attribs' );
			$images			= $type == 'images' ? (array) $this->config->get( $this->_name . '_at_img_' . $attribute_id . '_' . $lang_id ) : array();
			
			/**
			 * SQL 
			 */
			$sql			= "
				SELECT
					REPLACE(REPLACE(TRIM(`pa`.`text`), '\r', ''), '\n', '') AS `text`,
					`pa`.`attribute_id`
				FROM
					`" . DB_PREFIX . "product_attribute` AS `pa`
				INNER JOIN
					`" . DB_PREFIX . "product` AS `p`
				ON
					`pa`.`product_id` = `p`.`product_id` AND `p`.`status` = '1'
				WHERE
					`pa`.`attribute_id` = " . (int) $this->request->get['attribute_id'] . " AND
					`pa`.`language_id` = '" . (int)$lang_id . "'
				GROUP BY
					`text`, `pa`.`attribute_id`
			";
			$unique = array();
			foreach( $this->db->query( $sql )->rows as $row ) {
				$row['text'] = trim( $row['text'] );
				
				if( ! empty( $settings['attribute_separator'] ) ) {
					$row['text'] = array_map( 'trim', explode( $settings['attribute_separator'], $row['text'] ) );
					
					foreach( $row['text'] as $text ) {
						if( isset( $unique[$text] ) ) continue;
						
						$k = md5( $text );
						
						$json[] = array( 'key' => $k, 'val' => $text, 'ival' => isset( $images[$k] ) ? $images[$k] : '', 'img' => isset( $images[$k] ) ? $this->model_tool_image->resize( $images[$k], 100, 100 ) : '' );
						$unique[$text] = true;
					}
				} else if( ! isset( $unique[$row['text']] ) ) {
					$k = md5( $row['text'] );
					$json[] = array( 'key' => $k, 'val' => $row['text'], 'ival' => isset( $images[$k] ) ? $images[$k] : '', 'img' => isset( $images[$k] ) ? $this->model_tool_image->resize( $images[$k], 100, 100 ) : '' );
					$unique[$row['text']] = true;
				}
			}
			
			$this->_sortOptions( $json, ! empty( $attribs[$attribute_id]['sort_order_values'] ) ? $attribs[$attribute_id]['sort_order_values'] : '', $attribute_id, $lang_id );
			
			$json2 = array();
			
			foreach( $json as $v ) {
				$json2[] = $v;
			}
			
			$json = $json2;
		}
		
		$this->response->setOutput( json_encode( $json ) );
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function filtersReset() {
		if( ! empty( $this->request->post['filter_id'] ) && ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			$filter_id = (int)$this->request->post['filter_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type = (string)$this->request->post['type'];
			
			switch( $type ) {
				case 'images' : $type = 'img'; break;
				default : $type = 'sort';
			}
			
			// główny sklep
			$this->model_setting_setting->deleteSetting($this->_name . '_fi_' . $type . '_' . $filter_id . '_' . $lang_id );
			
			// pozostałe sklepy			
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->deleteSetting($this->_name . '_fi_' . $type . '_' . $filter_id . '_' . $lang_id, $result['store_id']);
			}	
		}
	}
	
	public function filtersSave() {
		if( ! empty( $this->request->post['filter_id'] ) && ! empty( $this->request->post['items'] ) || ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$data		= array();
			$filter_id	= (int) $this->request->post['filter_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type		= $this->request->post['type'];
			
			if( isset( $this->request->post['items'] ) ) {
				foreach( $this->request->post['items'] as $i => $v ) {
					switch( $type ) {
						case 'images' : {
							$data[$v['key']] = $v['img'];

							break;
						}
					}
				}
			}
			
			switch( $type ) {
				case 'images' : {
					$type = 'img'; 
					
					break;
				}
			}
			
			$key	= $this->_name . '_fi_' . $type . '_' . $filter_id . '_' . $lang_id;
			$data	= array( $key => $data );
			
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			
			// główny sklep
			$this->model_setting_setting->editSetting($key, $data);
			
			// pozostałe sklepy
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($key, $data, $result['store_id']);
			}
		}
	}
	
	public function getFiltersValuesByFilterAsJson() {
		$json = array();
		
		if( ! empty( $this->request->get['filter_id'] ) && ! empty( $this->request->get['type'] ) && ! empty( $this->request->get['lang_id'] ) ) {
			$this->load->model('tool/image');
			
			/**
			 * Parametry 
			 */
			$filter_id	= $this->request->get['filter_id'];
			$lang_id	= $this->request->get['lang_id'];
			$type		= $this->request->get['type'];
			$images		= $type == 'images' ? (array) $this->config->get( $this->_name . '_fi_img_' . $filter_id . '_' . $lang_id ) : array();
			
			/**
			 * SQL 
			 */
			$sql			= "
				SELECT
					`fd`.`name`,
					`f`.`filter_id`
				FROM
					`" . DB_PREFIX . "filter_description` AS `fd`
				INNER JOIN
					`" . DB_PREFIX . "filter` AS `f`
				ON
					`fd`.`filter_id` = `f`.`filter_id`
				WHERE
					`f`.`filter_group_id` = " . (int) $filter_id . " AND
					`fd`.`language_id` = '" . (int)$lang_id . "'
				ORDER BY
					`fd`.`name`
			";
			
			foreach( $this->db->query( $sql )->rows as $row ) {
				$json[] = array(
					'key' => $row['filter_id'],
					'val' => $row['name'],
					'ival' => isset( $images[$row['filter_id']] ) ? $images[$row['filter_id']] : '',
					'img' => isset( $images[$row['filter_id']] ) ? $this->model_tool_image->resize( $images[$row['filter_id']], 100, 100 ) : ''
				);
			}
		}
		
		$this->response->setOutput( json_encode( $json ) );
	}
	
	private static function _sortItems( $a, $b ) {
		$as = isset( self::$_tmp_sort_parameters['config'][$a['key']] ) ? self::$_tmp_sort_parameters['config'][$a['key']] : count(self::$_tmp_sort_parameters['config']);
		$bs = isset( self::$_tmp_sort_parameters['config'][$b['key']] ) ? self::$_tmp_sort_parameters['config'][$b['key']] : count(self::$_tmp_sort_parameters['config']);
		
		if( $as > $bs )
			return 1;
		
		if( $as < $bs )
			return -1;
		
		return 0;
	}
	
	private function _sortOptions( & $options, $sort, $attribute_id, $lang_id ) {		
		if( $sort ) {
			list( $type, $order ) = explode( '_', $sort );
		} else {
			$type = $order = '';
		}
		
		if( $attribute_id ) {
			$attribute_id = str_replace(array(
				'a_', 'o_', 'f_'
			), '', $attribute_id);
		}
		
		self::$_tmp_sort_parameters = array(
			'attribute_id'	=> $attribute_id,
			'type'			=> $type,
			'order'			=> $order,
			'a'				=> false,
			'options'		=> $options,
			'config'		=> $this->config->get('mega_filter_at_sort_' . $attribute_id . '_' . $lang_id )
		);
		
		if( ! self::$_tmp_sort_parameters['type'] && ! self::$_tmp_sort_parameters['config'] ) {
			self::$_tmp_sort_parameters = NULL;
			
			return;
		}
		
		if( ! self::$_tmp_sort_parameters['type'] && self::$_tmp_sort_parameters['attribute_id'] !== NULL && self::$_tmp_sort_parameters['config'] ) {
			uasort( $options, array( 'ControllerModuleMegaFilter', '_sortItems' ) );
		} else {
			$tmp = array();
			
			foreach( $options as $k => $v ) {
				$tmp['_'.$k] = htmlspecialchars_decode( $v['name'] );
			}
			
			if( $order == 'desc' ) {
				arsort( $tmp, $type == 'string' ? SORT_STRING : SORT_NUMERIC );
			} else {
				asort( $tmp, $type == 'string' ? SORT_STRING : SORT_NUMERIC );
			}
			
			$tmp2 = array();
			
			foreach( $tmp as $k => $v ) {
				$tmp2[trim($k,'_')] = $options[trim($k,'_')];
			}
		
			$options = $tmp2;
		}
			
		self::$_tmp_sort_parameters = NULL;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	private function _getOptionItems( $start = NULL, $limit = NULL, $filter = NULL ) {
		$items = array();
		$sql = "
			SELECT 
				* 
			FROM 
				`" . DB_PREFIX . "option` AS `o` 
			LEFT JOIN 
				`" . DB_PREFIX . "option_description` AS `od` 
			ON 
				`o`.`option_id` = `od`.`option_id` 
			WHERE 
				`od`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' AND
				`o`.`type` IN( 'select', 'radio', 'checkbox', 'image' )
		";
		
		if( $filter ) {
			$sql .= " AND `od`.`name` LIKE '%" . $this->db->escape( $filter ) . "%'";
		}
		
		if( $start !== NULL && $limit !== NULL ) {
			$sql .= 'LIMIT ' . (int) ( $start ) . ', ' . ( (int) $limit );
		}
		
		foreach( $this->db->query( $sql )->rows as $option ) {
			$items[$option['option_id']] = $option;
		}
		
		return $items;
	}
	
	private function _getTotalOptionItems( $filter = NULL ) {
		$sql = "
			SELECT 
				COUNT(*) AS c 
			FROM 
				`" . DB_PREFIX . "option` AS `o` 
			LEFT JOIN 
				`" . DB_PREFIX . "option_description` AS `od` 
			ON 
				`o`.`option_id` = `od`.`option_id` 
			WHERE 
				`od`.`language_id` = '" . (int)$this->config->get('config_language_id') . "' AND
				`o`.`type` IN( 'select', 'radio', 'checkbox', 'image' )
		";
		
		if( $filter ) {
			$sql .= " AND `od`.`name` LIKE '%" . $this->db->escape( $filter ) . "%'";
		}
		
		return $this->db->query( $sql )->row['c'];
	}
	
	/**
	 * Ustawienia opcji 
	 */
	public function options() {
		$this->_init( 'options' );
		
		$page = isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;
		$config = $this->config->get($this->_name . '_options');
		$limit = 100;//$this->config->get('config_admin_limit');
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/options', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			if( ! empty( $this->request->post[$this->_name . '_options'] ) ) {
				foreach( $this->request->post[$this->_name . '_options'] as $id => $conf ) {
					$config[$id] = $conf;
				}
			}
			
			$ids = array_keys( $this->_getOptionItems() );
			
			foreach( $config as $id => $conf ) {
				if( ! in_array( $id, $ids ) ) {
					unset( $config[$id] );
				}
			}
			
			// główny sklep
			$this->model_setting_setting->editSetting($this->_name . '_options', array(	$this->_name . '_options' => $config ));
			
			// pozostałe sklepy			
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_options', array(	$this->_name . '_options' => $config ), $result['store_id']);
			}	
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/options', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL'));
		}
		
		$this->data['optionItems'] = $this->_getOptionItems( $page-1, $limit );
		$this->data['options'] = $config;
		
		$pagination = new Pagination();
		$pagination->total = $this->_getTotalOptionItems();
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/mega_filter/options', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->response->setOutput( $this->load->view('module/mega_filter_options.tpl', $this->data) );
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	private function _getFilterItems( $start = NULL, $limit = NULL, $filter = NULL ) {
		$items = array();
		$sql = "
			SELECT 
				* 
			FROM 
				`" . DB_PREFIX . "filter_group` AS `fg` 
			INNER JOIN 
				`" . DB_PREFIX . "filter_group_description` AS `fgd` 
			ON 
				`fg`.`filter_group_id` = `fgd`.`filter_group_id` AND `fgd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
		";
		
		if( $filter ) {
			$sql .= " AND `fgd`.`name` LIKE '%" . $this->db->escape( $filter ) . "%'";
		}
		
		if( $start !== NULL && $limit !== NULL ) {
			$sql .= 'LIMIT ' . (int) ( $start ) . ', ' . (int) $limit;
		}
		
		foreach( $this->db->query( $sql )->rows as $filter ) {
			$items[$filter['filter_group_id']] = $filter;
		}
		
		return $items;
	}
	
	private function _getTotalFilterItems( $filter = NULL ) {
		$sql = "
			SELECT 
				COUNT(*) AS c 
			FROM 
				`" . DB_PREFIX . "filter_group` AS `fg` 
			INNER JOIN 
				`" . DB_PREFIX . "filter_group_description` AS `fgd` 
			ON 
				`fg`.`filter_group_id` = `fgd`.`filter_group_id` AND `fgd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'
		";
		
		if( $filter ) {
			$sql .= " AND `fgd`.`name` LIKE '%" . $this->db->escape( $filter ) . "%'";
		}
		
		return $this->db->query( $sql )->row['c'];
	}
	
	/**
	 * Ustawienia filtrów 
	 */
	public function filters() {
		$this->_init( 'filters' );
		
		$page = isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;
		$config = $this->config->get($this->_name . '_filters');
		$limit = 100;//$this->config->get('config_admin_limit');
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/filters', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			if( ! empty( $this->request->post[$this->_name . '_filters'] ) ) {
				foreach( $this->request->post[$this->_name . '_filters'] as $id => $conf ) {
					$config[$id] = $conf;
				}
			}
			
			$ids = array_keys( $this->_getFilterItems() );
			
			foreach( $config as $id => $conf ) {
				if( ! in_array( $id, $ids ) ) {
					unset( $config[$id] );
				}
			}
			
			// główny sklep
			$this->model_setting_setting->editSetting($this->_name . '_filters', array(	$this->_name . '_filters' => $config ));
			
			// pozostałe sklepy
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_filters', array(	$this->_name . '_filters' => $config ), $result['store_id']);
			}	
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/filters', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL'));
		}
		
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$this->data['filterItems'] = $this->_getFilterItems();
		$this->data['filters'] = $config;
		$this->data['filters_view'] = true;
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->data['action_filters_save'] = $this->url->link('module/' . $this->_name . '/filtersSave', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_filters_reset'] = $this->url->link('module/' . $this->_name . '/filtersReset', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_values_by_filter'] = $this->url->link('module/' . $this->_name . '/getFiltersValuesByFilterAsJson', 'token=' . $this->session->data['token'], 'SSL');
		
		$pagination = new Pagination();
		$pagination->total = $this->_getTotalFilterItems();
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/mega_filter/filters', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->response->setOutput( $this->load->view('module/mega_filter_filters.tpl', $this->data) );
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	private function _updateCss() {
		/* @var $settings array */
		$settings = $this->config->get( $this->_name . '_settings' );
		
		/* @var $css string */
		$css = $this->_createCss( $settings );
		
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'mega_filter_module'" )->rows as $row ) {
			$row['value'] = version_compare( VERSION, '2.1.0.0', '>=' ) ? json_decode( $row['value'], true ) : unserialize( $row['value'] );
			
			foreach( $row['value'] as $k => $v ) {
				if( ! empty( $v['configuration'] ) ) {
					$css .= $css ? "\n" : '';
					$css .= $this->_createCss(  $v['configuration'], '.mfilter-box-' . $k );
				}
			}
		}
		
		file_put_contents( DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf/style-2.css', $css );
	}
	
	private function _createCss( $settings, $prefix = '' ) {
		if( $prefix ) {
			$prefix .= ' ';
		}
		
		$css = '
			' . $prefix . '.mfilter-counter {
				background: #' . ( empty( $settings['background_color_counter'] ) ? '428BCA' : trim( $settings['background_color_counter'], '#' ) ) . ';
				color: #' . ( empty( $settings['text_color_counter'] ) ? 'FFFFFF' : trim( $settings['text_color_counter'], '#' ) ) . ';
			}
			' . $prefix . '.mfilter-counter:after {
				border-right-color: #' . ( empty( $settings['background_color_counter'] ) ? '428BCA' : trim( $settings['background_color_counter'], '#' ) ) . ';
			}
		';
		
		if( ! empty( $settings['css_style'] ) ) {
			$css .= htmlspecialchars_decode( $settings['css_style'] );
		}
	
		if( ! empty( $settings['background_color_search_button'] ) ) {
			$css .= '
				' . $prefix . '.mfilter-search #mfilter-opts-search_button {
					background-color: #' . trim( $settings['background_color_search_button'], '#' ) . ';
				}
			';
		}
		
		if( ! empty( $settings['background_color_slider'] ) ) {
			$css .= '
				' . $prefix . '.mfilter-slider-slider .ui-slider-range,
				' . $prefix . '#mfilter-price-slider .ui-slider-range {
					background: #' . trim( $settings['background_color_slider'], '#' ) . ' !important;
				}
			';
		}
		
		if( ! empty( $settings['background_color_header'] ) ) {
			$css .= '
				' . $prefix . '.mfilter-heading {
					background: #' . trim( $settings['background_color_header'], '#' ) . ';
				}
			';
		}
		
		if( ! empty( $settings['text_color_header'] ) ) {
			$css .= '
				' . $prefix . '.mfilter-heading {
					color: #' . trim( $settings['text_color_header'], '#' ) . ';
				}
			';
		}

		if( ! empty( $settings['border_bottom_color_header'] ) ) {
			$css .= '
				' . $prefix . '.mfilter-opts-container {
					border-top-color: #' . trim( $settings['border_bottom_color_header'], '#' ) . ';
				}
			';
		}
		
		if( ! empty( $settings['background_color_widget_button'] ) ) {
			$css .= '
				' . $prefix . '.mfilter-free-button {
					background-color: #' . trim( $settings['background_color_widget_button'], '#' ) . ';
					border-color: #' . trim( $settings['background_color_widget_button'], '#' ) . ';
				}
			';
		}
		
		return $css;
	}
	
	private function _writableCss() {
		$path = DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf/style-2.css';
		
		if( ! file_exists( $path ) ) {
			return false;
		}
		
		if( ! is_writable( $path ) ) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Ustawienia modułu 
	 */
	public function settings() {
		$this->_init( 'settings' );
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/settings', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_clear_cache']	= $this->url->link('module/' . $this->_name . '/clearcache', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['settings'] = $this->config->get($this->_name . '_settings');
		
		if( ! $this->_writableCss() ) {
			$this->_setErrors(array(
				'warning' => $this->language->get( 'error_css_file' )
			));
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			if( ! empty( $this->request->post[$this->_name . '_settings']['cache_enabled'] ) && ! $this->_cacheWritable() ) {
				$this->request->post[$this->_name . '_settings']['cache_enabled'] = '0';
				
				$this->session->data['error'] = $this->language->get('error_cache_dir');
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
			}
			
			$this->_saveSettings($this->_name . '_settings', $this->request->post);
			
			if( ! empty( $_POST['replace_settings'] ) ) {
				foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'mega_filter_module'" )->rows as $row ) {
					$row['value'] = version_compare( VERSION, '2.1.0.0', '>=' ) ? json_decode( $row['value'], true ) : unserialize( $row['value'] );
					
					foreach( $row['value'] as $k => $v ) {
						if( ! empty( $v['configuration'] ) ) {
							foreach( $v['configuration'] as $k2 => $v2 ) {
								if( isset( $this->request->post[$this->_name . '_settings'][$k2] ) ) {
									$row['value'][$k]['configuration'][$k2] = $this->request->post[$this->_name . '_settings'][$k2];
								}
							}
						}
					}
					
					$this->db->query( "
						UPDATE 
							`" . DB_PREFIX . "setting` 
						SET 
							value = '" . $this->db->escape( version_compare( VERSION, '2.1.0.0', '>=' ) ? json_encode( $row['value'] ) : serialize( $row['value'] ) ) . "' 
						WHERE 
							setting_id = " . $row['setting_id'] 
					);
				}
			}
			
			if( $this->_writableCss() ) {
				$this->_updateCss();
			}
			
			if( $this->_hasMFilterPlus() ) {
				$before = empty( $this->data['settings']['attribute_separator'] ) ? '' : $this->data['settings']['attribute_separator'];
				$after = empty( $this->request->post['mega_filter_settings']['attribute_separator'] ) ? '' : $this->request->post['mega_filter_settings']['attribute_separator'];

				if( $before != $after ) {
					$this->response->redirect($this->url->link('module/' . $this->_name . '/installprogress', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/settings', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if( ! isset( $this->data['settings']['in_stock_status'] ) )
			$this->data['settings']['in_stock_status'] = 7;
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/stock_status');
		$this->data['stockStatuses'] = $this->model_localisation_stock_status->getStockStatuses(array());
		$this->data['mfp_plus_version'] = $this->config->get('mfilter_plus_version');
				
		$this->response->setOutput( $this->load->view('module/mega_filter_settings.tpl', $this->data) );
	}
	
	/**
	 * SEO
	 */
	public function seo() {
		$this->_init( 'seo' );
		
		$this->data['action'] = $this->url->link('module/' . $this->_name . '/seo', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['aliases_url'] = $this->url->link('module/' . $this->_name . '/aliases', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['seo'] = $this->config->get($this->_name . '_seo');
		
		if( ! $this->_writableCss() ) {
			$this->_setErrors(array(
				'warning' => $this->language->get( 'error_css_file' )
			));
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			// główny sklep
			$this->model_setting_setting->editSetting($this->_name . '_seo', $this->request->post);
			
			// pozostałe sklepy
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_seo', $this->request->post, $result['store_id']);
			}
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/seo', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->response->setOutput( $this->load->view('module/mega_filter_seo.tpl', $this->data) );
	}
	
	/**
	 * Aliases
	 */
	public function aliases() {
		$this->_init( 'aliases' );
		
		$this->load->model('localisation/language');
		$this->load->model('setting/store');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['aliases_url'] = $this->url->link('module/' . $this->_name . '/aliases', 'token=' . $this->session->data['token'], 'SSL');
		
		if( NULL == ( $language_id = isset( $this->request->get['language_id'] ) ? $this->request->get['language_id'] : NULL ) ) {
			foreach( $this->data['languages'] as $language ) {
				$language_id = $language['language_id']; break;
			}
		}
		
		$this->data['language_id'] = $language_id;
		$this->data['stores'] = array( 0 => array( 'store_id' => 0, 'name' => $this->language->get( 'text_default' ) ) );
		
		foreach( $this->model_setting_store->getStores() as $v ) {
			$this->data['stores'][] = $v;
		}
		
		if( NULL == ( $store_id = isset( $this->request->get['store_id'] ) ? $this->request->get['store_id'] : NULL ) ) {
			foreach( $this->data['stores'] as $store ) {
				$store_id = $store['store_id']; break;
			}
		}
		
		$this->data['store_id'] = $store_id;
		$this->data['val_url'] = isset( $this->request->get['url'] ) ? $this->request->get['url'] : '';
		$this->data['val_alias'] = isset( $this->request->get['alias'] ) ? $this->request->get['alias'] : '';
		
		if( ! empty( $this->request->get['action'] ) && $this->checkPermission() ) {
			switch( $this->request->get['action'] ) {
				case 'insert' : {
					if( 
						NULL != ( $url = isset( $this->request->get['url'] ) ? $this->request->get['url'] : '' ) &&
						NULL != ( $alias = isset( $this->request->get['alias'] ) ? $this->request->get['alias'] : '' ) 
					) {
						$url = parse_url( trim( urldecode( $url ) ) );
						$alias = parse_url( trim( $alias ) );
						
						if( NULL != ( $path = empty( $url['query'] ) ? ( empty( $url['path'] ) ? '' : $url['path'] ) : $url['query'] ) ) {
							preg_match( '/(\?|&)?mfp(,|=)?(,?[a-z0-9\-_]+\[[^\]]*\])+/', $path, $matches );
							
							if( ! empty( $matches[0] ) ) {
								if( ! empty( $alias['path'] ) ) {
									$main = parse_url( HTTP_CATALOG );

									if( ! empty( $main['path'] ) ) {
										$url['path'] = preg_replace( '/^' . preg_quote( $main['path'], '/' ) . '/', '', $url['path'] );
									}
									
									$apath	= $bpath = preg_replace( '/ +/', '-', trim( $alias['path'], '/ ' ) );
									$loops	= 0;
									
									do {
										$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `keyword` LIKE '" . $this->db->escape( $apath ) . "'");
										
										if( ! $query->num_rows ) {
											$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `alias` LIKE '" . $this->db->escape( $apath ) . "' AND `store_id` = '" . (int) $store_id . "' AND `language_id` = '" . (int) $language_id . "'");
										}
										
										if( $query->num_rows ) {
											$apath = $bpath . '-' . rand( 0, 10000 );
											$loops++;
										}
									} while( $query->num_rows );
									
									$this->db->query("
										INSERT INTO `" . DB_PREFIX . "mfilter_url_alias` SET
											`path` = '" . $this->db->escape( empty( $url['path'] ) ? '' : trim( preg_replace( '/\/mfp,([a-z0-9\-_]+\[[^\]]*\],?)+/', '', $url['path'] ), '/' ) ) . "',
											`mfp` = '" . $this->db->escape( preg_replace( '/^mfp(=|,)/', '', $matches[0] ) ) . "',
											`alias` = '" . $this->db->escape( $apath ) . "',
											`language_id` = '" . (int) $language_id . "',
											`store_id` = '" . (int) $store_id . "'
									");
									
									$this->data['_success'] = $this->language->get( 'success_updated' );
									$this->data['val_url'] = $this->data['val_alias'] = '';
									
									if( $loops >= 1 ) {
										$this->data['_success'] .= ' - ' . $this->language->get( 'success_updated_modified_url' );
									}
								} else {
									$this->data['_error_warning'] = $this->language->get( 'error_invalid_seo_url' );
								}
							} else {
								$this->data['_error_warning'] = $this->language->get( 'error_invalid_url' );
							}
						} else {
							$this->data['_error_warning'] = $this->language->get( 'error_invalid_url' );
						}
					} else {
						$this->data['_error_warning'] = $url ? $this->language->get( 'error_invalid_seo_url' ) : $this->language->get( 'error_invalid_url' );
					}
					
					break;
				}
				case 'remove' : {
					if( ! empty( $this->request->get['id'] ) ) {
						$this->db->query( "DELETE FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `mfilter_url_alias_id`='" . (int) $this->request->get['id'] . "'" );
					}
					
					break;
				}
			}
			
			foreach( $this->data['stores'] as $store ) {
				$this->cache->delete('seo_pro_mfp.'.$this->config->get('store_id'));
			}
		}
		
		$page	= isset( $this->request->get['page'] ) ? (int) $this->request->get['page'] : 1;
		$limit	= 25;
		$total	= $this->db->query( "SELECT COUNT(*) AS `c` FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `language_id`='" . $language_id . "' AND `store_id`='" . $store_id . "'" )->row['c'];
		
		do {
			$this->data['records'] = $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `language_id`='" . $language_id . "' AND `store_id`='" . $store_id . "' LIMIT " . ( ( $page - 1 < 0 ? 0 : $page - 1 ) * $limit ) . ", " . $limit )->rows;
		} while( count( $this->data['records'] ) <= 0 && $page-- );
		
		if( $page < 1 ) {
			$page = 1;
		}
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/mega_filter/ldv', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		$this->data['page'] = $page;
		
		$this->response->setOutput( $this->load->view('module/mega_filter_aliases.tpl', $this->data) );
	}
	
	/**
	 * Ustaw błędy
	 * 
	 * @param array $errors
	 */
	private function _setErrors( $errors ) {
		foreach( $errors as $name => $default ) {
			$this->data['_error_' . $name] = isset( $this->error[$name] ) ? $this->error[$name] : $default;
		}
	}
	
	/**
	 * Ustaw parametry
	 * 
	 * @param array $params
	 * @param array $record
	 */
	private function _setParams( $params, $record = NULL ) {
		if( ! $record )
			$record = array();
		
		foreach( $params as $param => $default ) {
			if( isset( $this->request->post[$param] ) )
				$this->data[$param] = $this->request->post[$param];
			else if( isset( $record[$param] ) )
				$this->data[$param] = $record[$param];
			else
				$this->data[$param] = $default;
		}
	}
	
	private function _clearCache( $messages ) {
		if( ! $this->_cacheWritable() ) {
			if( $messages ) {
				$this->session->data['error'] = $this->language->get('error_cache_dir');
			}
		} else {	
			$dir	= @ opendir( $this->_cache_dir );
			$items	= 0;

			while( false !== ( $file = readdir( $dir ) ) ) {
				if( strlen( $file ) > 32 && strpos( $file, 'idx.' ) === 0 ) {
					@ unlink( $this->_cache_dir . '/' . $file );

					$items++;
				}
			}

			closedir( $dir );

			if( $messages ) {
				$this->session->data['success'] = sprintf( $this->language->get('success_cache_clear'), $items );
			}
		}
	}
	
	public function clearcache() {
		$this->language->load('module/' . $this->_name);
		
		$this->_clearCache( true );
		
		$this->response->redirect($this->url->link('module/mega_filter/settings', 'token=' . $this->session->data['token'], 'SSL'));
	}
			
	public function category_autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_catalog_category->getCategories_MF($data);
				
			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}
	
	/**
	 * About
	 */
	public function about() {
		$this->_init( 'about' );
		
		$this->data['ext_version'] = $this->_version;
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/about', 'token=' . $this->session->data['token'], 'SSL');
		
		if( $this->config->get('mfilter_plus_version') ) {
			$this->data['plus_version'] = $this->config->get('mfilter_plus_version');
			$this->data['action_rebuild_index'] = $this->data['action']	= $this->url->link('module/' . $this->_name . '/installprogress', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_about.tpl', $this->data) );
	}
	
	/**
	 * Set tooltip
	 */
	public function setTooltip() {
		$this->load->model('localisation/language');
		
		/* @var $data array */
		$data = array(
			'languages' => array(),
			'title' => '',
			'values' => array()
		);
		
		/* @var $type string */
		$type = $this->request->get['type'];
		
		/* @var $idx int */
		$idx = (int) $this->request->get['idx'];
		
		/* @var $id int */
		$id = (int) $this->request->get['id'];
		
		if( ! in_array( $type, array( 'attribute', 'option', 'filter_group' ) ) ) {
			$type = 'attribute';
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->db->query( "UPDATE `" . DB_PREFIX . $type . "_description` SET `mf_tooltip` = NULL WHERE `" . $type . "_id` = " . $id );
			
			foreach( $this->request->post['languages'] as $language_id => $value ) {
				if( $value !== '' ) {
					$this->db->query( "UPDATE `" . DB_PREFIX . $type . "_description` SET `mf_tooltip` = '" . $this->db->escape( $value ) . "' WHERE `language_id` = " . (int) $language_id . " AND `" . $type . "_id` = " . $id );
				}
			}
			
			$this->_clearCacheByIdx( $idx );
		}
			
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . $type . "_description` WHERE `" . $type . "_id` = " . $id )->rows as $row ) {
			$data['values'][$row['language_id']] = $row['mf_tooltip'];
			
			if( $row['language_id'] == $this->config->get('config_language_id' ) ) {
				$data['title'] = $row['name'];
			}
		}
		
		foreach( $this->model_localisation_language->getLanguages() as $language ) {
			$data['languages'][$language['language_id']] = $language['name'];
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_set_tooltip.tpl', $data) );
	}
	
	private function getURL($url, $post = null) {
		return '1';
	}
	
	private function activate( $order_id = NULL, $email = NULL ) {
		/* @var $domains array */
		$domains = array( 0 => HTTP_CATALOG );
		
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "store`" )->rows as $row ) {
			$domains[$row['store_id']] = $row['url'];
		}
		
		/* @var $extensions array */
		$extensions = array( 'mega_filter_pro' => $this->_version );
		
		if( $this->_hasMFilterPlus() ) {
			$extensions['mega_filter_plus'] = $this->config->get('mfilter_plus_version');
		}
		
		/* @var $url string */
		foreach( $domains as $store_id => $url ) {
			/* @var $params */
			$params = parse_url( $url );
			
			/* @var $request array */
			$request = array();
			
			if( $order_id && $email ) {
				$request[] = 'order_id=' . urlencode( $order_id );
				$request[] = 'order_email=' . urlencode( $email );
			}
			
			if( ! empty( $params['host'] ) ) {
				/* @var $theme array */
				$theme = $this->db->query( "SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` IN('config_theme','config_template') AND `code`='config' AND `store_id`=" . (int) $store_id )->row;
				
				$request[] = 'h=' . urlencode( $params['host'] );
				$request[] = 'p=' . urlencode( isset( $params['path'] ) ? $params['path'] : '/' );
				$request[] = 'o=' . urlencode( VERSION );
				$request[] = 't=' . urlencode( isset( $theme['value'] ) ? (string) $theme['value'] : '' );
				
				foreach( $extensions as $extension => $version ) {
					$url = 'http://activate.ocdemo.eu/?e=' . urlencode( $extension ) . '&v=' . urlencode( $version ) . '&' . implode( '&', $request );
					
					if( false != ( $response = $this->getURL( $url ) ) ) {
						if( $response == '-1' ) {
							return false;
						} else if( $response != '1' ) {
							$response = unserialize( $response );

							if( $response['status'] == 'success' ) {			
								if( ! empty( $response['files'] ) ) {
									foreach( $response['files'] as $file => $source ) {
										file_put_contents( DIR_SYSTEM . '../' . $file, $source );
									}
								}
							} else {
								$this->session->data['error'] = $response['message'];

								return false;
							}
						}
					} else {
						$this->session->data['error'] = 'Error connecting to activation server';

						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	/**
	 * About
	 */
	public function license() {
		if( $this->config->get('mfilter_license') ) {
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->_init( 'license' );
		
		$this->data['action'] = $this->url->link('module/' . $this->_name . '/license', 'token=' . $this->session->data['token'], 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' ) {
			if( empty( $_POST['order_id'] ) || empty( $_POST['oc_email'] ) ) {
				$this->data['_error_warning2'] = 'Please enter Order ID and OpenCart email';
			} else if( ! $this->activate( $_POST['order_id'], $_POST['oc_email'] ) ) {
				$this->data['_error_warning2'] = 'Your Order ID is invalid, please try again or contact us <a href="mailto:info@ocdemo.eu">info@ocdemo.eu</a>';
				
				if( ! empty( $this->session->data['error'] ) ) {
					$this->data['_error_warning2'] .= '<br><br>' . $this->session->data['error'];
					unset( $this->session->data['error'] );
				}
			} else {
				$this->_saveSettings('mfilter_license', array(
					'mfilter_license' => array(
						'order_id' => md5( $_POST['order_id'] ),
						'email' => md5( mb_strtolower( $_POST['oc_email'], 'utf8' ) ),
						'time' => time()
					)
				));
		
				$this->session->data['success'] = $this->language->get('success_install');

				$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		
		if( empty( $this->session->data['mfp_license_verification'] ) ) {
			$this->session->data['mfp_license_verification'] = $this->activate();
			
			unset( $this->session->data['mfp_license_verification'] );
		}
		
		/* @var $files array */
		$files = array(
			DIR_SYSTEM . 'library/mfilter_core.php',
			DIR_SYSTEM . 'library/mfilter_module.php'
		);
		
		foreach( $files as $k => $v ) {
			if( file_exists( $v ) && is_writable( $v ) ) {
				unset( $files[$k] );
			}
		}
		
		$this->data['files'] = $files;
		
		$this->response->setOutput( $this->load->view('module/mega_filter_license.tpl', $this->data) );
	}
	
	private function _installMFilterPlus() {
		if( ! $this->_hasMFilterPlus() ) {
			return false;
		}
		
		if( ! file_exists( DIR_SYSTEM . 'library/mfilter_plus.php' ) ) {
			return false;
		}

		require_once DIR_SYSTEM . 'library/mfilter_plus.php';
		
		if( Mfilter_Plus::getInstance( $this )->install() ) {
			$this->response->redirect($this->url->link('module/' . $this->_name . '/installprogress', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function installprogress() {
		if( ! $this->_hasMFilterPlus() ) {
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			require_once DIR_SYSTEM . 'library/mfilter_plus.php';
			
			echo json_encode( Mfilter_Plus::getInstance( $this )->installprogress() );
			
			return;
		}
		
		$this->_init( 'installprogress' );
		
		$this->data['progress_action'] = $this->url->link('module/' . $this->_name.'/installprogress', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['main_action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		
		$this->response->setOutput( $this->load->view('module/mega_filter_installprogress.tpl', $this->data) );
	}
	
	/**
	 * Add column to table
	 * 
	 * @param string $table
	 * @param string $column
	 * @param string $type
	 * @return boolean 
	 */
	private function _addColumn( $table, $column, $type ) {		
		$query = $this->db->query('SHOW COLUMNS FROM `' . DB_PREFIX . $table . '` LIKE "' . $column . '"');
		
		if( ! $query->num_rows ) {
			$this->db->query( 'ALTER TABLE `' . DB_PREFIX . $table . '` ADD `' . $column . '` ' . $type );
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * Remove column from table
	 * 
	 * @param string $table
	 * @param string $column
	 * @return bool 
	 */
	private function _removeColumn( $table, $column ) {		
		$query = $this->db->query('SHOW COLUMNS FROM `' . DB_PREFIX . $table . '` LIKE "' . $column . '"');
		
		if( $query->num_rows ) {
			$this->db->query('ALTER TABLE `' . DB_PREFIX . $table . '` DROP `' . $column . '`');
			
			return true;
		}
		
		return false;
	}
	
	private function _updateDB( $install = false ) {
		if( $install || version_compare( $this->config->get( 'mfilter_version' ), '2.0.4.4.5.2', '<' ) ) {
			$this->_addColumn( 'attribute_description', 'mf_tooltip', 'TEXT NULL' );
			$this->_addColumn( 'option_description', 'mf_tooltip', 'TEXT NULL' );
			$this->_addColumn( 'filter_group_description', 'mf_tooltip', 'TEXT NULL' );
		}
	}
	
	/**
	 * Instalacja
	 */
	public function install() {		
		$this->language->load('module/' . $this->_name);
		
		// załaduj modele
		$this->load->model('setting/setting');
		$this->load->model('extension/extension');
		$this->load->model('localisation/language');
		
		$titles = array();
		
		foreach( $this->model_localisation_language->getLanguages() as $language ) {
			$titles[$language['language_id']] = 'Mega Filter PRO';
		}
			
		/**
		 * Wprowadź domyślne ustawienia 
		 */
		$this->model_setting_setting->editSetting($this->_name . '_module', array(
			$this->_name . '_module' => array(
				1 => array(
					'title'			=> $titles,
					'layout_id'		=> array( '3' ),
					'store_id'		=> array( 0 ),
					'position'		=> 'column_left',
					'status'		=> '1',
					'sort_order'	=> ''
				)
			)
		));
		
		$this->model_setting_setting->editSetting($this->_name . '_settings', array(
			$this->_name . '_settings' => array(
				'show_number_of_products'		=> '1',
				'calculate_number_of_products'	=> '1',
				'show_loader_over_results'		=> '1',
				'css_style'					=> '',
				'content_selector'			=> '#mfilter-content-container',
				'refresh_results'			=> 'immediately',
				'attribs'					=> array(
					'price'		=> array(
						'enabled'		=> '1',
						'sort_order'	=> '-1'
					)
				),
				'layout_c'					=> '3',
				'display_live_filter'		=> array(
					'items' => '1'
				)
			)
		));
		
		$this->model_setting_setting->editSetting($this->_name . '_seo', array(
			$this->_name . '_seo' => array(
				'enabled'	=> '0'
			)
		));
		
		$this->model_setting_setting->editSetting($this->_name . '_status', array(
			$this->_name . '_status' => '1'
		));
		
		/**
		 * Sprawdź czy wtyczka jest na liście 
		 */
		if( ! in_array( $this->_name, $this->model_extension_extension->getInstalled('module') ) ) {
			$this->model_extension_extension->install('module', $this->_name);
		}
		
		/**
		 * Sprawdź czy jest duplikat na liście
		 */
		$idx = 0;
		foreach( $this->db->query( "SELECT * FROM " . DB_PREFIX . "extension WHERE code='mega_filter' AND type='module'")->rows as $row ) {
			if( $idx ) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE extension_id='" . (int) $row['extension_id'] . "'");
			}
			
			$idx++;
		}
		
		$this->_updateDB( true );
			
		$this->_installMFilterPlus();
		
		$this->session->data['success'] = $this->language->get('success_install');

		$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	/**
	 * Deinstalacja
	 */
	public function uninstall() {
		$this->language->load('module/' . $this->_name);	
			
		/**
		 * Sprawdź czy wtyczka jest na liście 
		 */
		$this->load->model('extension/extension');
		$this->load->model('setting/store');
		
		$this->db->query("
			DELETE FROM
				`" . DB_PREFIX . "setting`
			WHERE
				`key` IN('mega_filter_module','mega_filter_status','mfilter_version','mfilter_license','mega_filter_attribs','mega_filter_settings', 'mega_filter_seo','mega_filter_filters','mega_filter_options','mfilter_plus_version','mfilter_mijoshop') OR
				`key` REGEXP '^mega_filter_at_img_[0-9]+_[0-9]+$' OR 
				`key` REGEXP '^mega_filter_fi_img_[0-9]+_[0-9]+$' OR 
				`key` REGEXP '^mega_filter_at_sort_[0-9]+_[0-9]+$'
		");
			
		$this->_removeColumn( 'attribute_description', 'mf_tooltip' );
		$this->_removeColumn( 'option_description', 'mf_tooltip' );
		$this->_removeColumn( 'filter_group_description', 'mf_tooltip' );
			
		// @since 2.0.3.2
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "mfilter_url_alias`");
			
		if( in_array( $this->_name, $this->model_extension_extension->getInstalled('module') ) )
			$this->model_extension_extension->uninstall('module', $this->_name);
		
		if( file_exists( DIR_SYSTEM . 'library/mfilter_plus.php' ) ) {
			require_once DIR_SYSTEM . 'library/mfilter_plus.php';
			Mfilter_Plus::getInstance( $this )->uninstall();
		}
		
		foreach( $this->_mijoshop_update as $file => $changes ) {
			$file = realpath( DIR_SYSTEM . $file );
			
			if( file_exists( $file . '_backup_mf' ) ) {
				if( copy( $file . '_backup_mf', $file ) ) {
					unlink( $file . '_backup_mf' );
				}
			}
		}
		
		$this->session->data['success'] = $this->language->get('success_uninstall');

		// przekieruj do listy modułów
		$this->response->redirect( $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL') );
	}
	
	/**
	 * Zweryfikuj prawnienia
	 * 
	 * @return boolean
	 */
	protected function hasPermission() {
		if( ! $this->user->hasPermission('modify', 'module/' . $this->_name) )
			return false;
		
		return true;
	}
	
	protected function checkPermission() {
		if( ! $this->hasPermission() ) {
			$this->_setErrors(array(
				'warning'	=> $this->language->get( 'error_permission' )
			));
			
			return false;
		}
		
		return true;
	}
}