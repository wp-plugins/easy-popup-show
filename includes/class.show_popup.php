<?php
class epsShowPopup {
	function __construct() {	
	add_action("wp_footer", array($this, "eps_front_end_display"));	
	}

	private function showStatements($locations, $check, $popsid, $archive_id) {
			if(in_array("all_loc", $locations)){
				do_shortcode('[eps_pop id="'. $popsid . '"]');
			} elseif(in_array("archive_only", $locations) && is_archive()) {
				do_shortcode('[eps_pop id="'. $popsid . '"]');
			} elseif(in_array("home_only", $locations) && is_home() && is_front_page()) {
				do_shortcode('[eps_pop id="'. $popsid . '"]');
			} elseif(in_array("excl_home", $locations) && !is_home() && !is_front_page()) {
				do_shortcode('[eps_pop id="'. $popsid . '"]');
			} 
		}
		
		private function showStatements404($locations, $popsid) {
				if(in_array("404_page", $locations) || !in_array("no_404_page", $locations)) {			
				do_shortcode('[eps_pop id="'. $popsid . '"]');
				}
		}
	
	function eps_front_end_display($post) {
	global $post, $wpdb;	

		function isFromSearchEngine() {
			if(isset($_SERVER['HTTP_REFERER'])) {
			$seDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			$seDomain = preg_match("/[^\.\/]+\.[^\.\/]+$/", $seDomain, $match);
			$seDomain = preg_match("/.([^.]*)\./", $match[0], $match);
				switch($match[0]) {
					case 'google.':
					case 'yahoo.':
					case 'search.':
					case 'lycos.':
					case 'bing.':
					case 'msn.':
					case 'yandex.':
					case 'baidu.':
					case 'munax.':
					case 'blekko.':
					case 'duckduckgo.':
					case 'exalead.':
					case 'gigablast.':
					case 'qwant.':
					case 'sogou.':
					case 'youdao.':
					return true;
					break;
					default:
					return false;
				}		
		}	
	}
	
	function isEPSMobile() {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))		
		return true;
	}
			wp_reset_query();
		// include_once("epsshowit.php");
		if(!is_404() && !empty($post)){
			/*CURRENT PAGE INFO*/
			$page_info = array();	
			
			// current post type
			$post_type = get_post_type(get_the_ID());
			$page_info[] = $post_type;
			
			// current post taxonomy name
				$taxonomy_names = get_object_taxonomies($post_type, 'objects');
				
					foreach($taxonomy_names as $tax){		

						$terms = wp_get_object_terms(get_the_ID(), $tax->name);
							$page_info[] = $post_type . "__" . $tax->name;
							foreach($terms as $term){
							// current post term's item name
								$post_type . "__" . $tax->name . "__" . $term->name . "<br/>";
							}		
					}

			// $single_id = $post->ID;
			$this_pdate = strtotime(get_the_date());
			
			// current post ID
				$post_id = get_the_ID();
			$page_info[] = $post_type . "__" . $post_id;
			// current post Author
			$page_author = "author_" . get_the_author_meta('ID');
			//echo $page_author;
			$page_info[] = $post_type . "__" . $page_author;
			// print_r($page_info);
			// print_r($post);
// echo "BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB";
			$archive_id = get_queried_object_id();

			//echo $single_id . "<br/>" . $archive_id;
			 $queried_object = get_queried_object();

			 //echo $queried_object->taxonomy;

			 //print_r( $queried_object );
			$the_query = new WP_Query( array('post_type' => 'easy_popup_show') );
				if ($the_query->have_posts()) {
				
					while ( $the_query->have_posts() ){
					$the_query->the_post();
					
						//POPUP IDs
						$popsid = get_the_ID();
						
						// Pop Ups Data
						$on = get_post_meta( $popsid, '_on_off_switch', true);
						// $theme = get_post_meta($popsid, '_eps_popup_theme', true);
						$dates = get_post_meta($popsid, '_eps_date_key', true);
						$locations = get_post_meta($popsid, '_eps_locations_key', true);
						$rules = get_post_meta($popsid, '_eps_display_rules', true);

						// include_once("themes/" . $theme . ".php");
	if($on != '') {
			if(!empty($locations) || is_array($locations)) {
			$check = array_intersect($locations, $page_info);

						
	if(in_array('use_cookies', $rules)) {
		if(	!isset($_COOKIE[$popsid . "_eps"])) {	
		      if(in_array('sev_only', $rules)){
			    if(isFromSearchEngine()) {	
				 if(in_array('exclude_mobile', $rules)){
					if(!isEPSMobile()) {
					   if(in_array('to_login_user', $rules)) {
						if(is_user_logged_in() || !is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }

						}
					  } else {
						if(!is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						 }
						}
					   }
					} else {
						   if(in_array('to_login_user', $rules)) {
						if(is_user_logged_in() || !is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }

						}
					  } else {
						if(!is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						 }
						}	
					   }
					 }
					} else {
					 if(in_array('exclude_mobile', $rules)){
						if(!isEPSMobile()) {
						   if(in_array('to_login_user', $rules)) {
							if(is_user_logged_in() || !is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }

							}
						  } else {
							if(!is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							 }
							}
						   }
						} else {
							   if(in_array('to_login_user', $rules)) {
							if(is_user_logged_in() || !is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
							  }

							}
						  } else {
							if(!is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
									$this->showStatements($locations, $check, $popsid, $archive_id);
								}
								}
								}	
							}					
							}	
						}
					} else {
			if(in_array('sev_only', $rules)){
			    if(isFromSearchEngine()) {	
				 if(in_array('exclude_mobile', $rules)){
					if(!isEPSMobile()) {
					   if(in_array('to_login_user', $rules)) {
						if(is_user_logged_in() || !is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }

						}
					  } else {
						if(!is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						 }
						}
					   }
					} else {
						   if(in_array('to_login_user', $rules)) {
						if(is_user_logged_in() || !is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }

						}
					  } else {
						if(!is_user_logged_in()) {
						  if($dates[0] != "" || $dates[1] != ""){					
							if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
						  }
						 }
						}	
					   }
					 }
					} else {
					 if(in_array('exclude_mobile', $rules)){
						if(!isEPSMobile()) {
						   if(in_array('to_login_user', $rules)) {
							if(is_user_logged_in() || !is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }

							}
						  } else {
							if(!is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							 }
							}
						   }
						} else {
							   if(in_array('to_login_user', $rules)) {
							if(is_user_logged_in() || !is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
							  }

							}
						  } else {
							if(!is_user_logged_in()) {
							  if($dates[0] != "" || $dates[1] != ""){					
								if(strtotime($dates[0]) <= $this_pdate && strtotime($dates[1]) >= $this_pdate) {
									$this->showStatements($locations, $check, $popsid, $archive_id);
							  }
							  } else {
								$this->showStatements($locations, $check, $popsid, $archive_id);
								}
							  }
							 }	
							}					
						}					
					}
				  }
				}
			}		/* Restore original Post Data */
					wp_reset_postdata();					
		} 

	} elseif(is_404() || empty($post)){
				$the_query = new WP_Query( array('post_type' => 'easy_popup_show') );
				if ($the_query->have_posts()) {				
					while ( $the_query->have_posts() ){
					$the_query->the_post();					
						//POPUP IDs
						$popsid = get_the_ID();
						
						// Pop Ups Data
						$on = get_post_meta( $popsid, '_on_off_switch', true);
						// $theme = get_post_meta($popsid, '_eps_popup_theme', true);
						$locations = get_post_meta($popsid, "_eps_locations_key", true);
						$rules = get_post_meta($popsid, "_eps_display_rules", true);
/* 						$cookie = get_post_meta($popsid, '_eps_cookie_rule', true);
						$expiry = get_post_meta($popsid, '_eps_cookie_history', true); */
						// include_once("themes/" . $theme . ".php");
				if($on != '') {
					if(!empty($locations) || is_array($locations)) {
					  if(in_array('use_cookies', $rules)) {
						if(	!isset($_COOKIE[$popsid . "_eps"])) {	
							  if(in_array('sev_only', $rules)){
								if(isFromSearchEngine()) {	
								 if(in_array('exclude_mobile', $rules)){
									if(!isEPSMobile()) {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}
									   }
									} else {
									 if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}	
									   }
									 }
									} else {
									 if(in_array('exclude_mobile', $rules)){
										if(!isEPSMobile()) {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}
										   }
										} else {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}
											}					
											}	
										}
									} else {
										if(in_array('sev_only', $rules)){
											if(isFromSearchEngine()) {	
											 if(in_array('exclude_mobile', $rules)){
												if(!isEPSMobile()) {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}
									   }
									} else {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}
									   }
									 }
									} else {
									 if(in_array('exclude_mobile', $rules)){
										if(!isEPSMobile()) {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}
										   }
										} else {
									   if(in_array('to_login_user', $rules)) {
										if(is_user_logged_in() || !is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										}
									  } else {
										if(!is_user_logged_in()) {
												$this->showStatements404($locations, $popsid);
										 }
										}	
											}					
										}					
									}
							}
						}
					}
					wp_reset_postdata();					
				}
		}
	}
}

//print_r($check);
new epsShowPopup();
?>