<?php
$default__tab = null;
$__tab = isset($_GET['tab']) ? $_GET['tab'] : $default__tab;
global $API_KEY;
global $__mg__page;
$API_KEY = 'fe820d7cf8a922a22d399cad5db275cc';
$__mg__page = 1;
// $API_KEY = get_option($tmdb);
add_action('template_redirect', 'wpse149613_form_process');
?>
<div class="wrap">
  <!-- Print the page title -->
  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <nav class="nav-tab-wrapper">
    <a href="?page=admin.php" class="nav-tab <?php if ($__tab === null) : ?>nav-tab-active<?php endif; ?>">Import Tab</a>
    <a href="?page=admin.php&tab=settings" class="nav-tab <?php if ($__tab === 'settings') : ?>nav-tab-active<?php endif; ?>">Settings</a>
    <a href="?page=admin.php&tab=tools" class="nav-tab <?php if ($__tab === 'tools') : ?>nav-tab-active<?php endif; ?>">Tools</a>
  </nav>

  <div class="tab-content">
    <?php switch ($__tab):
      case 'settings':
        __mg__settings__cont();
        break;
      case 'tools':
        // $args = array(
        //   'style'       => 'list',
        //   'hide_empty'  => 0,
        //   );
        // $categories = get_categories($args);
        // foreach ($categories as $category) :

        //   echo  $category->term_id . ' ' . $category->name . '<br>';

        // endforeach;
        // echo 'Tools'.var_dump($categories);
        break;
      default:
        __mg__movie__cont();
        break;
    endswitch; ?>
  </div>
</div>

<?php

function __mg__settings__cont()
{
  if (isset($_POST['tmdb_key']) && isset($_POST['act_key'])) {
    $__tmdb_key = $_POST['tmdb_key'];
    $__act_key = $_POST['act_key'];
    $tmdb = '_DB_Key';
    if (!get_option($tmdb)) {
      add_option($tmdb, $__tmdb_key, $autoload = 'yes');
    }
    update_option($tmdb,  $__tmdb_key, $autoload = 'yes');
    $__MG_act = '_ACT_MG_Key';
    if (!get_option($__MG_act)) {
      add_option($__MG_act, $__act_key, $autoload = 'yes');
    }
    update_option($__MG_act, $__act_key, $autoload = 'yes');
    // echo'<script> window.setTimeout( function() {
    //   window.location.reload();
    // }, 500); </script>';
    echo '<div class="updated"><p>Update successfull ! </p></div>';
  }
  $__MG_DB_key = get_option('_DB_Key');
  $__MG_key = get_option('_ACT_MG_Key');
?>
  <div class="wrap">
    <h2>Settings</h2>
    <form method="post" action="?page=admin.php&tab=settings">
      <div class="row">
        <div class="p-3">
          <lable class="p-r">TMDB Api Key : </lable>
          <input value="<?php echo $__MG_DB_key ?>" class="regular-text code" type="text" name="tmdb_key" id="tmdb_key" />
        </div>
        <div class="p-3">
          <lable class="p-r">Plugin Activation key : </lable>
          <input value="<?php echo $__MG_key ?>" class="regular-text code" type="text" id="act_key" name="act_key" />
        </div>
      </div>
      <input type="submit" value="Save Changes" name="submit" id="submit" class="button button-primary" />
    </form>
  </div>
<?php
}

?>

<?php
function  __mg__movie__cont()
{
  global $API_KEY;
  global $__mg__page;
  $__mg__page = 0;
  if (isset($_POST['__mo__page'])) {
    $__mg__page = $_POST['__mo__page'] + 1;
  }
?>
  <div class="wrap">
    <h2>Import</h2>
    <form method="post" id="mov__form" name='mov__form' action="?page=admin.php">
      <div class="row">
        <div class="p-3">
          <select id="__mv__select__op__">
            <option value="mov">Movie</option>
            <option value="tv">Tv show</option>
          </select>
        </div>
        <!-- <div class="p-3">
          <input type="text" placeholder="Year" name="__mov__year" id="__mov__year">
        </div> -->
        <div class="p-3">
          <input type="text" placeholder="Search Name" name="__mo__name" id="__mo__name">
        </div>
        <div class="p-3">
          <input type="submit" value="Search" name="submit" id="submit" class="button button-primary" />
          <input type="hidden" value="<?php echo $__mg__page ?>" name="__mo__page" id="__mo__page" class="button button-primary" />
        </div>
        <div class="p-3">
          <a href="javascript:{}" onclick="document.getElementById('submit').click();"><button class="button button-primary"><?php echo ($__mg__page == 0) ?  'Load'  : 'Next'; ?></button></a>
        </div>
      </div>
    </form>
  </div>

<?php

  if (isset($_POST['__mo__name'])) {
    // https://api.themoviedb.org/3/search/movie?api_key=ssss&query=query&page=1&include_adult=false&region=region&year=year&primary_release_year=primary_release_year
    // https://api.themoviedb.org/3/search/tv?api_key=ssss&page=1&include_adult=false
    // https://api.themoviedb.org/3/search/multi?api_key=ssss&query=query&page=1&include_adult=false&region=region
    // $url = 'https://api.themoviedb.org/3/search/movie?api_key=fe820d7cf8a922a22d399cad5db275cc&query=Jack+Reacher';
    $__popular_mv_url = 'https://api.themoviedb.org/3/trending/all/day?api_key=fe820d7cf8a922a22d399cad5db275cc' . '&page=' . $__mg__page;
    // $__popular_mv_url = 'https://api.themoviedb.org/3/search/multi?api_key=fe820d7cf8a922a22d399cad5db275cc'.'&query='.$_POST['__mo__name'] . '&page=' . $__mg__page.'&include_adult=true&language=ta';
    // $__popular_mv_url = 'https://api.themoviedb.org/3/find/'.$_POST['__mo__name'].'?api_key=fe820d7cf8a922a22d399cad5db275cc&external_source=imdb_id';
    // $__popular_mv_url = 'https://api.themoviedb.org/3/discover/movie?api_key=fe820d7cf8a922a22d399cad5db275cc'.'&with_original_language=te&year=2019' . '&page=' . $__mg__page;
    // if (empty($_POST['__mo__name'])) {
    //   $__popular_mv_url = 'https://api.themoviedb.org/3/find/'+$_POST['__mo__name'] +'?api_key=fe820d7cf8a922a22d399cad5db275cc&language=en-US&external_source=imdb_id';
    // }
    $__header_args = array(
      'headers' => array("Content-type" => "application/json")
    );
    $result = wp_remote_get($__popular_mv_url, $__header_args);
    $response_code = wp_remote_retrieve_response_message($result);
    $response = wp_remote_retrieve_body($result);
    $response = json_decode($response);
    if ($response_code == 'OK') {
      // print("<pre>".print_r($response,true)."</pre>");
        echo '<div class="d-flex-wrap">';
        if (!$response->results) {
          if (!$response->results) {
            
          } 
        }else{
          foreach ($response->results as $mv) {
            echo '<div class="wrap">';
            if ($mv->poster_path) {
              echo '<a href="?page=admin.php&mv_id=' . $mv->id . '" /><img src="https://image.tmdb.org/t/p/w92/' . $mv->poster_path . '"/></a>';
            }else{
              echo '<a href="?page=admin.php&mv_id=' . $mv->id . '" /><img src="../wp-content/plugins/wp-plugin/not-found.jpg"/></a>';
            }
            // 
            echo '</div>';
          }
        }
      
      // echo $_POST['__mov__year'];
      echo $_POST['__mo__name'];
      echo '</div>';
    }
    
  }
  // $selectOption = $_POST['taskOption'];


  //////////////////////////////  one movie eka ganna   ////////////////////////
  if (!empty($_GET['mv_id'])) {
    // echo $_GET['mv_id'];
    $__single__mv_url = 'https://api.themoviedb.org/3/movie/' . $_GET['mv_id'] . '?api_key=fe820d7cf8a922a22d399cad5db275cc';
    $args = array(
      'headers' => array("Content-type" => "application/json")
    );
    $result = wp_remote_get($__single__mv_url, $args);
    $response_code = wp_remote_retrieve_response_message($result);
    $response = wp_remote_retrieve_body($result);
    $response = json_decode($response);
    if ($response_code == 'OK') {
      $args = array(
        'style'       => 'list',
        'hide_empty'  => 0,
      );
      $categories = get_categories($args);
      $__cat__mv__name = array();
      $__cat__mv__full = array();
      foreach ($response->genres as $one_mv_cat) {
        foreach ($categories as $category) {
          if ($one_mv_cat->name == $category->name) {
            $__cat__mv__name[] = $one_mv_cat->name;
            $__cat__mv__full[] = $one_mv_cat;
          } else {
          }
        }
      }
      foreach ($response->genres as $key => $object) {
        if (!in_array($object->name, $__cat__mv__name)) {
          $__str_rpc = str_replace(' ', '-', $object->name);
          $__add__mv__cat = array(
            'cat_name' => $object->name,
            'category_description' => 'Movie Categary',
            'category_nicename' => $__str_rpc,
            'category_parent' => ''
          );
        }
        $wpdocs_cat_id = wp_insert_category($__add__mv__cat);
        print("<pre>" . print_r($wpdocs_cat_id, true) . "</pre>");
      }
      print("<pre>" . print_r($response, true) . "</pre>");
    }
    echo $__single__mv_url;
    echo $response_code;
  } else {
    echo 'none';
  }
}


?>