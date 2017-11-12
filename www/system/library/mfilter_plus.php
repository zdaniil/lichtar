<?php

class Mfilter_Plus {
	
	private $_version	= '1.2.2';
	
    private $_ctrl;
	
	private $_settings;
	
	private $_values = NULL;
	
	private static $_instance;
	
	private $_cache = array();
	
	////////////////////////////////////////////////////////////////////////////
	
	public function baseJoin( array $skip = array() ) {
		$sql = '';
		
		/*if( ! in_array( 'pmv', $skip ) && ( $this->_values['attribute'] || $this->_values['option'] || $this->_values['filter'] ) ) {
			$sql .= sprintf("
				INNER JOIN
					`" . DB_PREFIX . "product_mfilter_values` AS `pmv`
				ON
					`pmv`.`product_id` = `p`.`product_id`
			" );
		}*/
		
		return $sql;
	}
	
	public function baseConditions( & $conditions ) {
		
	}
	
	private function hasFilters() {
		if( $this->_hasFilters === NULL ) {
			$this->_hasFilters = version_compare( VERSION, '1.5.5', '>=' );
		}
		
		return $this->_hasFilters;
	}
	
	function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
	public function attribsToSQL( $join, $attribs ) {		
		$sql = array();
		
		foreach( $attribs as $kk => $val ) {
			list( $key ) = explode( '-', $kk );
			
			$sql2 = array();
			foreach( $val as $val2 ) {
				foreach( $val2 as $val3 ) {
					$val3 = is_array( $val3 ) ? $val3[0] : $val3;
					
					if( strpos( $val3, '&quot;' ) !== false ) {
						$val4 = md5( str_replace( '&quot;', '"', $this->_trim( $val3 ) ) );
						
						if( isset( $this->_values['attribute'][$val4.':'.$key] ) ) {
							$sql2[] = 'FIND_IN_SET( ' . $this->_values['attribute'][$val4.':'.$key] . ', `p`.`mfilter_values` )';
						}
					}
					
					$val3 = md5( $this->_trim( $val3 ) );
					
					if( isset( $this->_values['attribute'][$val3.':'.$key] ) ) {
						$sql2[] = 'FIND_IN_SET( ' . $this->_values['attribute'][$val3.':'.$key] . ', `p`.`mfilter_values` )';
					}
				}
			}
			
			if( $sql2 ) {
				$sql[] = '(' . implode( ! empty( $this->_settings['type_of_condition'] ) && $this->_settings['type_of_condition'] == 'and' ? ' AND ' : ' OR ', $sql2 ) . ')';
			}
		}
		
		if( $sql ) {			
			return $join . implode( ' AND ', $sql );
		}
		
		return '';
	}
	
	public function inStockStatus() {
		return $inStockStatus = empty( $this->_settings['in_stock_status'] ) ? 7 : $this->_settings['in_stock_status'];
	}
	
	public function stockStatusValues() {
		if( empty( $this->_ctrl->request->get['mfp'] ) ) {
			return array();
		}
		
		preg_match( '/stock_status\[([0-9,]+)\]/', $this->_ctrl->request->get['mfp'], $matches );
		
		if( empty( $matches[1] ) ) {
			return array();
		}
		
		return explode( ',', $matches[1] );
	}
	
	public function optionsToSQL( $join, $options, & $conditionsIn = NULL, & $conditionsOut = NULL ) {
		$sql = array();
		//$ids = array();
		
		foreach( $options as $val ) {
			$sql2 = array();
			
			foreach( $val as $val2 ) {
				$val2 = explode( ',', $val2 );
				
				foreach( $val2 as $val3 ) {
					if( isset( $this->_values['option'][$val3] ) ) {
						$sql3 = 'FIND_IN_SET( ' . $this->_values['option'][$val3] . ', `p`.`mfilter_values` )';
						
						if( ! empty( $this->_settings['stock_for_options_plus'] ) ) {
							if( ! empty( $this->_settings['in_stock_default_selected'] ) || in_array( $this->inStockStatus(), $this->stockStatusValues() ) ) {
								//$ids[] = $val3;
								$sql3 .= " AND ( SELECT	SUM(`quantity`) FROM `" . DB_PREFIX . "product_option_value` AS `pov` WHERE `p`.`product_id` = `pov`.`product_id` AND `option_value_id` = '" . $val3 . "' ) > 0";

								$sql3 = '( ' . $sql3 . ' )';
							}
						}
						
						$sql2[] = $sql3;
					}
				}
			}
			
			if( $sql2 ) {
				$sql[] = '(' . implode( ! empty( $this->_settings['type_of_condition'] ) && $this->_settings['type_of_condition'] == 'and' ? ' AND ' : ' OR ', $sql2 ) . ')';
			}
		}
		
		/*if( $ids && $conditionsIn !== NULL ) {
			$conditionsIn[] = "`p`.`product_id` IN(
				SELECT 
					`pov`.`product_id` 
				FROM 
					`" . DB_PREFIX . "product_option_value` AS `pov` 
				WHERE 
					`pov`.`option_value_id` IN(" . implode( ',', $ids ) . ") AND 
					`pov`.`quantity` > 0
			)";
		}*/
		
		if( $sql ) {		
			return $join . implode( ' AND ', $sql );
		}
		
		return '';
	}
	
	public function filtersToSQL( $join, $filters ) {
		$sql = array();
		
		foreach( $filters as $val ) {
			$sql2 = array();
			
			foreach( $val as $val2 ) {
				$val2 = explode( ',', $val2 );
				
				foreach( $val2 as $val3 ) {
					if( isset( $this->_values['filter'][$val3] ) ) {
						$sql2[] = 'FIND_IN_SET( ' . $this->_values['filter'][$val3] . ', `p`.`mfilter_values` )';
					}
				}
			}
			
			if( $sql2 ) {
				$sql[] = '(' . implode( ! empty( $this->_settings['type_of_condition'] ) && $this->_settings['type_of_condition'] == 'and' ? ' AND ' : ' OR ', $sql2 ) . ')';
			}
		}
		
		if( $sql ) {
			return $join . implode( ' AND ', $sql );
		}
		
		return '';
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	private function _trim( $val ) {
		$val = stripslashes( $val );
		$val = preg_replace( "/^'|'$/", '', $val );
		
		return $val;
	}
	
	public function setValues( $attribs, $options, $filters ) {
		if( $this->_values !== NULL )
			return $this;
		
		$this->_values = array(
			'attribute'	=> array(),
			'option'	=> array(),
			'filter'	=> array()
		);
		$value		= array();
		$value_id	= array();
		
		foreach( $attribs as $key => $val ) {
			$key = explode('-', $key);
			$key = $key[0];
					
			foreach( $val as $val2 ) {
				$value = array_merge( $value, $val2 );
				
				foreach( $val2 as $val3 ) {
					if( is_array( $val3 ) ) {
						foreach( $val3 as $val4 ) {
							$this->_values['attribute'][md5( $this->_trim( $val4 ) ).':'.$key] = '-1';
						}
					} else {
						$this->_values['attribute'][md5( $this->_trim( $val3 ) ).':'.$key] = '-1';
					}
				}
			}
		}
		
		foreach( $options as $val ) {
			$value_id = array_merge( $value_id, $val );
		}
		
		foreach( $filters as $val ) {
			$value_id = array_merge( $value_id, $val );
		}
		
		if( ! $value && ! $value_id ) {
			return $this;
		}
		
		$sql = '';
		
		if( $value ) {			
			foreach( $value as $k => $val ) {
				if( is_array( $val ) ) {
					$val = $val[0];
				}
				
				$value[$k] = "'" . md5( $this->_trim( $val ) ) . "'";
				
				if( strpos( $val, '&quot;' ) !== false ) {
					$value[] = "'" . md5( str_replace( '&quot;', '"', $this->_trim( $val ) ) ) . "'";
				}
			}
			
			$sql .= sprintf( '`value` IN(%s)', implode( ',', $value ) );
		}
		
		if( is_array( $value_id ) && $value_id ) {
			$sql .= $sql ? ' OR ' : '';
			$sql .= sprintf( '`value_id` IN(%s)', implode( ',', $value_id ) );
		}
		
		$sql = "SELECT * FROM `" . DB_PREFIX . "mfilter_values` WHERE " . $sql;
		
		foreach( $this->db->query( $sql )->rows as $row ) {
			$this->_values[$row['type']][$row['type']=='attribute'?$row['value'].':'.$row['value_id']:$row['value_id']] = $row['mfilter_value_id'];						
		}
		
		return $this;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public static function getInstance( $ctrl, array $settings = array() ) {
		if( ! self::$_instance )
			self::$_instance = new Mfilter_Plus( $ctrl, $settings );
		
		return self::$_instance;
	}
    
    private function __construct( $ctrl, array $settings = array() ) {
        $this->_ctrl = $ctrl;
		$this->_settings = $settings ? $settings : $this->config->get('mega_filter_settings');
	}
    
    public function __get( $name ) {
        return $this->_ctrl->{$name};
    }
	
	/**
	 * Instalacja 
	 */
	public function install() {
		$version = $this->config->get('mfilter_plus_version');
		
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'mfilter_values` (
				`mfilter_value_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`type` ENUM("attribute","option","filter") NOT NULL,
				`value` CHAR(32) NULL DEFAULT NULL,
				`value_id` INT(11) NULL DEFAULT NULL,
				PRIMARY KEY (`mfilter_value_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1'
		);
		
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'mfilter_tags` (
				`mfilter_tag_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`tag` CHAR(32) NOT NULL,
				PRIMARY KEY (`mfilter_tag_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1'
		);
		
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		
		// główny sklep
		$this->model_setting_setting->editSetting('mfilter_plus_version', array(
			'mfilter_plus_version' => $this->version()
		));
			
		// pozostałe sklepy
		foreach( $this->model_setting_store->getStores() as $result ) {
			$this->model_setting_setting->editSetting('mfilter_plus_version', array(
				'mfilter_plus_version' => $this->_version
			), $result['store_id']);
		}
		
		if( $this->_addColumn( 'product', 'mfilter_values', 'TEXT NOT NULL DEFAULT ""' ) ) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD FULLTEXT(`mfilter_values`)");
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "mfilter_values` ADD UNIQUE( `type`, `value`, `value_id` )");
			
			if( $this->_addColumn( 'product', 'mfilter_tags', 'TEXT NOT NULL DEFAULT ""' ) ) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD FULLTEXT(`mfilter_tags`)");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "mfilter_tags` ADD INDEX( `tag` )");
			}
			
			return true;
		} else {
			$reindex = false;
			
			if( version_compare( $version, '1.0.1', '<' ) ) {
				$reindex = true;
			}
			
			if( version_compare( $version, '1.0.3', '<' ) ) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "mfilter_values` ADD UNIQUE( `type`, `value`, `value_id` )");
				
				$reindex = true;
			}
			
			if( version_compare( $version, '1.0.9', '<' ) ) {
				$reindex = true;
			}
			
			if( version_compare( $version, '1.2.2', '<' ) ) {
				if( $this->_addColumn( 'product', 'mfilter_tags', 'TEXT NOT NULL DEFAULT ""' ) ) {
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD FULLTEXT(`mfilter_tags`)");
					$this->db->query("ALTER TABLE `" . DB_PREFIX . "mfilter_tags` ADD INDEX( `tag` )");
					
					$reindex = true;
				}
			}
			
			return $reindex;
		}
	}
	
	/**
	 * Postęp instalacji 
	 */
	public function installprogress() {
		$steps	= array( 'attribute', 'option', 'product', 'tag' );
		$cache = DIR_CACHE . 'mfilter_plus-installprogress';
		
		if( $this->hasFilters() ) {
			$steps[] = 'filter';
		}
		
		if( file_exists( $cache ) ) {
			$this->session->data['mfilter_plus_install'] = unserialize( file_get_contents( $cache ) );
		}
		
		if( empty( $this->session->data['mfilter_plus_install'] ) ) {
			$this->session->data['mfilter_plus_install'] = array(
				'step'	=> 0,
				'idx'	=> 0,
				'_idx'	=> 0
			);
			
			$this->db->query( "TRUNCATE `" . DB_PREFIX . "mfilter_values`" );
			$this->db->query( "UPDATE `" . DB_PREFIX . "product` SET `mfilter_values` = ''" );
			
			$this->db->query( "TRUNCATE `" . DB_PREFIX . "mfilter_tags`" );
			$this->db->query( "UPDATE `" . DB_PREFIX . "product` SET `mfilter_tags` = ''" );
		}
		
		$step		= $this->session->data['mfilter_plus_install']['step'];
		$idx		= $this->session->data['mfilter_plus_install']['idx'];
		$_idx		= $this->session->data['mfilter_plus_install']['_idx'];
		$limit		= 100;
		$_limit		= 100;
		$progress	= 0;
		$_progress	= 0;
		$sql		= NULL;
		$rows		= 0;
		
		switch( $steps[$step] ) {
			case 'attribute' : {
				if( empty( $this->_settings['attribute_separator'] ) ) {
					$sql = "SELECT REPLACE(REPLACE(TRIM(`text`), '\r', ''), '\n', '') AS `val`, `attribute_id` AS `val_id` FROM `" . DB_PREFIX . "product_attribute` GROUP BY `val`, `val_id`";
				} else {
					$sql = "SELECT `text` AS `val`, `attribute_id` AS `val_id` FROM `" . DB_PREFIX . "product_attribute` GROUP BY `val`, `val_id`";
				}
				$rows = $this->db->query("SELECT COUNT(*) AS `c` FROM(SELECT * FROM `" . DB_PREFIX . "product_attribute` GROUP BY `text`) AS t");
				$rows = $rows->row['c'];
				
				break;
			}
			case 'option' : {
				$sql = "SELECT `option_value_id` AS `val_id` FROM `" . DB_PREFIX . "option_value`";
				$rows = $this->db->query("SELECT COUNT(*) AS `c` FROM `" . DB_PREFIX . "option_value`");
				$rows = $rows->row['c'];
				
				break;
			}
			case 'filter' : {
				$sql = "SELECT `filter_id` AS `val_id` FROM `" . DB_PREFIX . "filter_description`";
				$rows = $this->db->query("SELECT COUNT(*) AS `c` FROM `" . DB_PREFIX . "filter`");
				$rows = $rows->row['c'];
				
				break;
			}
			case 'tag' : {
				$sql = "SELECT `tag` AS `val` FROM `" . DB_PREFIX . "product_description`";
				$rows = $this->db->query("SELECT COUNT(*) AS `c` FROM `" . DB_PREFIX . "product_description`");
				$rows = $rows->row['c'];
				
				break;
			}
		}
		
		if( $sql ) {
			$sql .= ' LIMIT ' . ( $limit * $idx ) . ', ' . $limit;
			
			foreach( $this->db->query( $sql )->rows as $row ) {
				$values = array();
				
				if( $steps[$step] == 'attribute' ) {
					$values = empty( $this->_settings['attribute_separator'] ) ? array( $row['val'] ) : array_map( 'trim', explode( $this->_settings['attribute_separator'], $row['val'] ) );
				} else if( $steps[$step] == 'tag' ) {
					$values = array_map( 'trim', explode( ',', $row['val'] ) );
				} else {
					$values[] = $row['val_id'];
				}
				
				foreach( $values as $value ) {
					$val = NULL;
					$val_id = NULL;
					
					if( $steps[$step] == 'attribute' ) {
						$val = md5( $value );
						$val_id = $row['val_id'];
					} else if( $steps[$step] == 'tag' ) {
						$val = $value;
					} else {
						$val_id = $value;
					}

					if( ! $val && ! $val_id ) continue;

					if( $steps[$step] == 'tag' ) {
						if( $this->db->query(sprintf("
							SELECT 
								* 
							FROM 
								`" . DB_PREFIX . "mfilter_tags` 
							WHERE 
								`tag` = '%s'", 
							$this->db->escape( $val )
						))->num_rows ) continue;
						
						$this->db->query(sprintf("
							INSERT INTO
								`" . DB_PREFIX . "mfilter_tags`
							SET
								`tag` = '%s'
							", 
							$this->db->escape( $val )
						));
					} else {
						if( $this->db->query(sprintf("
							SELECT 
								* 
							FROM 
								`" . DB_PREFIX . "mfilter_values` 
							WHERE 
								`type` = '%s' AND `value` %s AND `value_id` %s", 
							$this->db->escape($steps[$step]), 
							$val === NULL ? 'IS NULL' : "= '" . $this->db->escape( $val ) . "'",
							$val_id === NULL ? 'IS NULL' : "= " . $val_id
						))->num_rows ) continue;

						$this->db->query(sprintf("
							INSERT INTO
								`" . DB_PREFIX . "mfilter_values`
							SET
								`type` = '%s',
								`value` = %s,
								`value_id` = %s
							", 
							$this->db->escape($steps[$step]), 
							$val === NULL ? 'NULL' : "'" . $this->db->escape( $val ) . "'",
							$val_id === NULL ? 'NULL' : $val_id
						));
					}
				}
			}
			
			$idx++;
			$_progress = 100;
		} else {
			$rows = $this->db->query("SELECT COUNT(*) AS `c` FROM `" . DB_PREFIX . "product`")->row['c'];
			$limit = 10;
			$_rows = 0;
			
			foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "product` LIMIT " . ( $limit * $idx ) . ', ' . $limit )->rows as $row ) {
				$this->updateProduct( $row['product_id'] );
			}
					
			$_idx++;
					
			$_progress = $_rows ? round( $_idx * $_limit / $_rows * 100, 2 ) : 100;
					
			if( $_progress >= 100 ) {
				$idx++;
				$_idx = 0;
			}
		}
		
		$progress = $rows ? round( $idx * $limit / $rows * 100, 3 ) : 100;
			
		if( $progress >= 100 ) {
			$step++;
			$idx = 0;
			$progress = 0;
			$_progress = 0;
		}
		
		$return = array(
			'success'	=> false,
			'steps'		=> count( $steps ),
			'progress'	=> $progress > 100 ? 100 : $progress,
			'_progress'	=> $_progress > 100 ? 100 : $_progress,
			'idx'		=> $idx,
			'_idx'		=> $_idx,
			'step'		=> $step + 1
		);
			
		if( $step >= count( $steps ) ) {
			unset( $this->session->data['mfilter_plus_install'] );
			
			if( file_exists( $cache ) ) {
				unlink( $cache );
			}
			
			$return['success'] = true;
		} else {
			$this->session->data['mfilter_plus_install']['idx'] = $idx;
			$this->session->data['mfilter_plus_install']['_idx'] = $_idx;
			$this->session->data['mfilter_plus_install']['step'] = $step;
			
			file_put_contents( $cache, serialize( $this->session->data['mfilter_plus_install'] ) );
		}
		
		return $return;
	}
	
	/**
	 * Deinstalacja 
	 */
	public function uninstall() {
		$this->db->query('DROP TABLE IF EXISTS `' . DB_PREFIX . 'mfilter_values`');
		
		$this->_removeColumn( 'product', 'mfilter_values' );
		
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		
		unset( $this->session->data['mfilter_plus_install'] );
			
		// główny sklep
		$this->model_setting_setting->deleteSetting( 'mfilter_plus_version' );
			
		// pozostałe sklepy			
		foreach( $this->model_setting_store->getStores() as $result ) {
			$this->model_setting_setting->deleteSetting( 'mfilter_plus_version', $result['store_id']);
		}	
	}
	
	/**
	 * Dodaj kolumnę do tabeli
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
	 * Usuń kolumnę z tabeli
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
	
	/**
	 * Wersja
	 * 
	 * @return string 
	 */
	public function version() {
		return $this->_version;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function updateProduct( $product_id ) {
		$attribs		= $this->db->query( "SELECT * FROM `" . DB_PREFIX . "product_attribute` WHERE `product_id` = " . (int) $product_id );
		$options		= $this->db->query( "SELECT * FROM `" . DB_PREFIX . "product_option_value` WHERE `product_id` = " . (int) $product_id );
		$filters		= $this->hasFilters() ? $this->db->query( "SELECT * FROM `" . DB_PREFIX . "product_filter` WHERE `product_id` = " . (int) $product_id ) : NULL;
		$tags			= $this->db->query( "SELECT product_id, tag FROM `" . DB_PREFIX . "product_description` WHERE `product_id` = " . (int) $product_id );
		$before			= array();
		$after			= array();
		$beforeTag		= array();
		$afterTag		= array();
		
		if( $attribs->num_rows || $options->num_rows || ( $filters && $filters->num_rows ) || $tags->num_rows ) {		
			$conditions		= array( 'attribs' => array(), 'options' => array(), 'filters' => array(), 'tags' => array() );
			$items			= array();

			foreach( $attribs->rows as $attrib ) {
				if( empty( $this->_settings['attribute_separator'] ) ) {
					$attrib['text'] = array( trim( $attrib['text'] ) );
				} else {
					$attrib['text'] = html_entity_decode($attrib['text'], ENT_QUOTES, 'UTF-8');
					$attrib['text'] = array_map( 'trim', explode( $this->_settings['attribute_separator'], $attrib['text'] ) );
					
					foreach( $attrib['text'] as $k => $v ) {
						$attrib['text'][$k] = htmlspecialchars($attrib['text'][$k], ENT_COMPAT, 'UTF-8');
					}
				}
				
				foreach( $attrib['text'] as $txt ) {
					if( $txt === '' ) continue;
					
					$txt = str_replace( array( "\n", "\r" ), '', $txt );
					$txt = md5( $txt );

					$conditions['attribs'][] = "( `value` = '" . $this->db->escape( $txt ) . "' AND `value_id` = " . $attrib['attribute_id'] . ')';
					$items['attribute'][] = array( 'v' => $txt, 'id' => $attrib['attribute_id'] );
				}
			}

			foreach( $options->rows as $option ) {
				$conditions['options'][] = $option['option_value_id'];
				$items['option'][] = $option['option_value_id'];
			}

			if( $filters ) {
				foreach( $filters->rows as $filter ) {
					$conditions['filters'][] = $filter['filter_id'];
					$items['filter'][] = $filter['filter_id'];
				}
			}
			
			foreach( $tags->rows as $tag ) {
				$tag['tag'] = array_map( 'trim', explode( ',', $tag['tag'] ) );
				
				foreach( $tag['tag'] as $v ) {
					if( $v === '' ) continue;
					
					if( ! empty( $items['tags'] ) && in_array( $v, $items['tags'] ) ) continue;
					
					$conditions['tags'][] = "`tag` = '" . $this->db->escape( $v ) . "'";
					$items['tags'][] = $v;
				}
			}
			
			$sql = array();
			$sqlTag = array();

			if( $conditions['attribs'] ) {
				$sql[] = "( `type` = 'attribute' AND (" . implode( ' OR ', $conditions['attribs'] ) . ") )";
			}
				
			if( $conditions['options'] ) {
				$sql[] = "( `type` = 'option' AND `value_id` IN(" . implode( ',', $conditions['options'] ) . ") )";
			}

			if( $conditions['filters'] ) {
				$sql[] = "( `type` = 'filter' AND `value_id` IN(" . implode( ',', $conditions['filters'] ) . ") )";
			}
			
			if( $conditions['tags'] ) {
				$sqlTag[] = implode( ' OR ', $conditions['tags'] );
			}

			$values	= array();

			if( $sql ) {
				$sql	= "SELECT * FROM `" . DB_PREFIX . "mfilter_values` WHERE " . implode( ' OR ', $sql );

				foreach( $this->db->query( $sql )->rows as $row ) {
					$values[$row['type']][$row['type']=='attribute'?$row['value'].':'.$row['value_id']:$row['value_id']] = $row['mfilter_value_id'];
				}
			}
			
			if( $sqlTag ) {
				$sqlTag = "SELECT * FROM `" . DB_PREFIX . "mfilter_tags` WHERE " . implode( ' OR ', $sqlTag );
				
				foreach( $this->db->query( $sqlTag )->rows as $row ) {
					$values['tags'][$row['tag']] = $row['mfilter_tag_id'];
				}
			}
			
			foreach( $items as $type => $vals ) {
				foreach( $vals as $val ) {
					if( $type == 'tags' ) {
						if( ! isset( $values['tags'][$val] ) ) {
							$this->db->query(sprintf("
								INSERT INTO
									`" . DB_PREFIX . "mfilter_tags`
								SET
									`tag` = '%s'
								",
								$this->db->escape( $val )
							));
							
							$afterTag[] = (string) $this->db->getLastId();
							$values['tags'][$val] = (string) $this->db->getLastId();
						} else {
							$afterTag[] = $values['tags'][$val];
						}
					} else {
						$key = $type == 'attribute' ? $val['v'] . ':' . $val['id'] : $val;

						if( ! isset( $values[$type][$key] ) ) {
							$this->db->query(sprintf("
								INSERT INTO
									`" . DB_PREFIX . "mfilter_values`
								SET
									`type` = '%s',
									`value` = %s,
									`value_id` = %s
								",
								$type,
								$type == 'attribute' ? "'" . $this->db->escape( $val['v'] ) . "'" : 'NULL',
								$type == 'attribute' ? $val['id'] : $val
							));

							$after[] = (string) $this->db->getLastId();
							$values[$type][$key] = (string) $this->db->getLastId();
						} else {
							$after[] = (string) $values[$type][$key];
						}
					}
				}
			}

			sort( $after, SORT_NUMERIC );
			sort( $afterTag, SORT_NUMERIC );
		}
		
		$product = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product` WHERE `product_id` = " . (int) $product_id )->row;
		
		$before = explode( ',', $product['mfilter_values'] );
		$beforeTag = explode( ',', $product['mfilter_tags'] );
		
		$this->db->query(sprintf("
			UPDATE
				`" . DB_PREFIX . "product`
			SET
				`mfilter_values` = '%s'
			WHERE
				`product_id` = %s
		", implode( ',', array_unique( $after ) ), $product_id));
		
		$this->db->query(sprintf("
			UPDATE
				`" . DB_PREFIX . "product`
			SET
				`mfilter_tags` = '%s'
			WHERE
				`product_id` = %s
		", implode( ',', array_unique( $afterTag ) ), $product_id));
		
		$diff = array_diff( $before, $after );
		$diffTag = array_diff( $beforeTag, $afterTag );
		
		if( $diff ) {
			foreach( $diff as $id ) {
				if( ! $this->db->query(sprintf("SELECT * FROM `" . DB_PREFIX . "product` WHERE FIND_IN_SET( '%s', `mfilter_values` ) LIMIT 1", $id))->num_rows ) {
					$this->_deleteMFilterValues(array($id));
				}
			}
		}
		
		if( $diffTag ) {
			foreach( $diffTag as $id ) {
				if( ! $this->db->query(sprintf("SELECT * FROM `" . DB_PREFIX . "product` WHERE FIND_IN_SET( '%s', `mfilter_tags` ) LIMIT 1", $id))->num_rows ) {
					$this->_deleteMFilterTags(array($id));
				}
			}
		}
	}
	
	private function _getMFilterValueIds( $type, $values ) {
		$mfilter_value_ids = array();
		$sql = sprintf("
			SELECT * FROM `" . DB_PREFIX . "mfilter_values` WHERE `type` = '%s' AND
		", $type);

		if( $type == 'attribute' ) {
			$vals = array();

			foreach( $values as $k => $v ) {
				$v = empty( $this->_settings['attribute_separator'] ) ? array( $v ) : array_map( 'trim', explode( $this->_settings['attribute_separator'], $v ) );

				foreach( $v as $v2 ) {
					$vals[] = "'" . $this->db->escape( $v2 ) . "'";
				}
			}

			if( ! $vals ) {
				$sql = NULL;
			} else {
				$sql .= sprintf( "`value` IN(%s)", implode( ',', $vals ) );
			}
		} else if( $values ) {
			$sql .= sprintf( "`value_id` IN(%s)", implode( ',', $values ) );
		} else {
			$sql = NULL;
		}

		if( $sql ) {
			foreach( $this->db->query( $sql )->rows as $row ) {
				$mfilter_value_ids[] = $row['mfilter_value_id'];
			}
		}
		
		return $mfilter_value_ids;
	}
	
	private function _deleteMFilterValues( $mfilter_ids ) {
		if( ! $mfilter_ids )
			return;
		
		foreach( $mfilter_ids as $k => $id ) {
			$mfilter_ids[$k] = (int) $id;
			
			$this->db->query(str_replace( '{val}', (int) $id, "
				UPDATE
					`" . DB_PREFIX . "product`
				SET
					`mfilter_values` = CASE 
						WHEN `mfilter_values` LIKE '%,{val},%'
							THEN REPLACE( `mfilter_values`, ',{val},', ',' )
						WHEN `mfilter_values` LIKE '{val},%'
							THEN REPLACE( `mfilter_values`, '{val},', '' )
						WHEN `mfilter_values` LIKE ',{val}%'
							THEN REPLACE( `mfilter_values`, ',{val}', '' )
					END
				WHERE
					FIND_IN_SET( '{val}', `mfilter_values` )
			"));
		}
		
		$this->db->query(sprintf("
			DELETE FROM
				`" . DB_PREFIX . "mfilter_values`
			WHERE
				`mfilter_value_id` IN(%s)
		", implode( ',', $mfilter_ids)));
	}
	
	private function _deleteMFilterTags( $mfilter_ids ) {
		if( ! $mfilter_ids )
			return;
		
		foreach( $mfilter_ids as $k => $id ) {
			$mfilter_ids[$k] = (int) $id;
			
			$this->db->query(str_replace( '{val}', (int) $id, "
				UPDATE
					`" . DB_PREFIX . "product`
				SET
					`mfilter_tags` = CASE 
						WHEN `mfilter_tags` LIKE '%,{val},%'
							THEN REPLACE( `mfilter_tags`, ',{val},', ',' )
						WHEN `mfilter_tags` LIKE '{val},%'
							THEN REPLACE( `mfilter_tags`, '{val},', '' )
						WHEN `mfilter_tags` LIKE ',{val}%'
							THEN REPLACE( `mfilter_tags`, ',{val}', '' )
					END
				WHERE
					FIND_IN_SET( '{val}', `mfilter_tags` )
			"));
		}
		
		$this->db->query(sprintf("
			DELETE FROM
				`" . DB_PREFIX . "mfilter_tags`
			WHERE
				`mfilter_tag_id` IN(%s)
		", implode( ',', $mfilter_ids)));
	}
	
	// FILTERS /////////////////////////////////////////////////////////////////
	
	public function deleteFilter( $filter_group_id ) {
		if( ! $this->hasFilters() )
			return;
		
		$filter_ids = array();
		
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "filter` WHERE `filter_group_id` = " . (int) $filter_group_id )->rows as $row ) {
			$filter_ids[] = $row['filter_id'];
		}
		
		if( ! $filter_ids )
			return;
		
		$this->_deleteMFilterValues( $this->_getMFilterValueIds( 'filter', $filter_ids ) );
	}
	
	public function editFilter( $data, $beforeFilterEdit ) {
		if( ! $this->hasFilters() )
			return;
		
		$after = array();
		$before = array();
		
		foreach ($data['filter'] as $row ) {
			if( $row['filter_id'] ) {
				$after[] = $row['filter_id'];
			}
		}
		
		foreach( $beforeFilterEdit as $row ) {
			$before[] = $row['filter_id'];
		}
		
		$diff = array_diff( $before, $after );
		
		if( ! $diff )
			return;
		
		$this->_deleteMFilterValues( $this->_getMFilterValueIds( 'filter', $diff ) );
	}
	
	// OPTIONS /////////////////////////////////////////////////////////////////
}