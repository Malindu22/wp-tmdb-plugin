<?php
$default__tab = null;
$__tab = isset($_GET['tab']) ? $_GET['tab'] : $default__tab;
global $API_KEY;
global $__mg__page;
$__mg__page = 1;
$API_KEY = get_option('_DB_Key');
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
    
    global $API_KEY;

  if (isset($_POST['__mo__name'])) {
    // https://api.themoviedb.org/3/search/movie?api_key=ssss&query=query&page=1&include_adult=false&region=region&year=year&primary_release_year=primary_release_year
    // https://api.themoviedb.org/3/search/tv?api_key=ssss&page=1&include_adult=false
    // https://api.themoviedb.org/3/search/multi?api_key=ssss&query=query&page=1&include_adult=false&region=region
    // $url = 'https://api.themoviedb.org/3/search/movie?api_key='.$API_KEY.'&query=Jack+Reacher';
    $__popular_mv_url = 'https://api.themoviedb.org/3/trending/all/day?api_key='.$API_KEY.'' . '&page=' . $__mg__page;
    // $__popular_mv_url = 'https://api.themoviedb.org/3/search/multi?api_key='.$API_KEY.''.'&query='.$_POST['__mo__name'] . '&page=' . $__mg__page.'&include_adult=true&language=ta';
    // $__popular_mv_url = 'https://api.themoviedb.org/3/find/'.$_POST['__mo__name'].'?api_key='.$API_KEY.'&external_source=imdb_id';
    // $__popular_mv_url = 'https://api.themoviedb.org/3/discover/movie?api_key='.$API_KEY.''.'&with_original_language=te&year=2019' . '&page=' . $__mg__page;
    if (!empty($_POST['__mo__name'])) {
      $__popular_mv_url = 'https://api.themoviedb.org/3/find/'.$_POST['__mo__name'] .'?api_key='.$API_KEY.'&language=en-US&external_source=imdb_id';
    }
    echo $__popular_mv_url;
    echo $__popular_mv_url;
    $__header_args = array(
      'headers' => array("Content-type" => "application/json")
    );
    $result = wp_remote_get($__popular_mv_url, $__header_args);
    $response_code = wp_remote_retrieve_response_message($result);
    $response = wp_remote_retrieve_body($result);
    $response = json_decode($response);
    if ($response_code == 'OK') {
      print("<pre>".print_r($response,true)."</pre>");
      $__type__m_t = 'movie';
        echo '<div class="d-flex-wrap">';
        if (!property_exists($response,'results')) {
          if (property_exists($response,'movie_results') &&  !empty($response->movie_results)) {
            $__response_result = $response->movie_results;
          }else if(property_exists($response,'tv_results') &&  !empty($response->tv_results)) {
            $__response_result = $response->tv_results;
            $__type__m_t = 'tv';
          }else{
            echo '<h2> No Data Found </h2>';
            return;
          }
          foreach ($__response_result as $mv) {
            echo '<div class="wrap">';
            if ($mv->poster_path) {
              echo '<a href="?page=admin.php&mv_id=' . $mv->id . '&type='.$__type__m_t.'" /><img src="https://image.tmdb.org/t/p/w92/' . $mv->poster_path . '"/></a>';
            }else{
              echo '<a href="?page=admin.php&mv_id=' . $mv->id . '&type='.$__type__m_t.'" /><img src="../wp-content/plugins/wp-plugin/not-found.jpg"/></a>';
            }
            echo '</div>';
          }
        }else{
          foreach ($response->results as $mv) {
            echo '<div class="wrap">';
            if ($mv->poster_path) {
              echo'=>';
              // echo '<a href="?page=admin.php&mv_id=' . $mv->id . '&type='.$__type__m_t.'" /><img src="https://image.tmdb.org/t/p/w92/' . $mv->poster_path . '"/></a>';
            }else{
              echo '<a href="?page=admin.php&mv_id=' . $mv->id . '&type='.$__type__m_t.'" /><img src="../wp-content/plugins/wp-plugin/not-found.jpg"/></a>';
            }
            // 
            echo '</div>';
          }
        }
      
      // echo $_POST['__mov__year'];
      echo $_POST['__mo__name'];
      echo $__popular_mv_url;
      echo '</div>';
    }
    
  }
  // $selectOption = $_POST['taskOption'];


  //////////////////////////////  one movie eka ganna   ////////////////////////
  if (!empty($_GET['mv_id']) && !empty($_GET['type'])) {
    global $API_KEY;
    // echo $__type__m_t;
    $__single__mv_url = 'https://api.themoviedb.org/3/'.$_GET['type'].'/'. $_GET['mv_id'] . '?api_key='.$API_KEY.'';
    $args = array(
      'headers' => array("Content-type" => "application/json")
    );
    $result = wp_remote_get($__single__mv_url, $args);
    $response_code = wp_remote_retrieve_response_message($result);
    $response = wp_remote_retrieve_body($result);
    $response = json_decode($response);
    print("<pre>" . print_r($response, true) . "</pre>");
    if ($response_code == 'OK') {
      $args = array(
        'style'       => 'list',
        'hide_empty'  => 0,
      );
      $all_req_category = $response->genres;
      $categories = get_categories($args);
      $__cat__mv__name = array();
      $equal__cat__id = array();
      foreach ($categories as $category) {
        foreach ($all_req_category as $key =>$one_mv_cat ) {
          if ($one_mv_cat->id == $category->description) {
            $__cat__mv__name[] = $one_mv_cat;
            $equal__cat__id[] = $one_mv_cat->id;
            unset($all_req_category[$key]);
          }
        }
      }


      if (!empty($all_req_category)) {
        foreach ($all_req_category as $key => $object) {
          $__str_rpc = str_replace(' ', '-', $object->name);
          $__add__mv__cat = array(
            'cat_name' => $object->name,
            'category_description' => $object->id,
            'category_nicename' => $__str_rpc,
            'category_parent' => ''
          );
        $wpdocs_cat_id = wp_insert_category($__add__mv__cat);
        // print("<pre>" . print_r($wpdocs_cat_id, true) . "</pre>");
          if ($wpdocs_cat_id == 0) {
            echo '"'.$object->name.'" Category Add failed <span class="danger"> <span class="dashicons dashicons-no"></span> </span>';
          }else{
            echo '"'.$object->name.'" Category Add success <span class="great"> <span class="dashicons dashicons-yes"></span> </span>';
          }
        }
      }

      $_mv_img = 'https://image.tmdb.org/t/p/w500'.$response->poster_path;
      $__description = 'short description';
      $return__image_id = media_sideload_image( $_mv_img, $__post_id, $__description,$src = 'id' );
      // print("<pre>" . print_r($return__image_id, true) . "</pre>");
      // echo $return__image_id;

      //get categary again to add post
      $__re__categories = get_categories($args);
      $__cat_id__to_post = array();
      foreach ($categories as $category) {
        foreach ($response->genres as $key =>$one_genres ) {
          if ($one_genres->id == $category->description) {
            array_push($__cat_id__to_post,$category->term_id);
          }
        }
      } 

      //////////////////////////// saved content of post //////////////////////////////////////
      if ($_GET['type'] == 'tv') {
        $__cont ="<!-- wp:heading {'level':3} --><h3>Overview :</h3>
                  <!-- /wp:heading -->
                  <!-- wp:paragraph {'fontSize':'small'} -->
                  <p class='has-small-font-size'>". $response->overview."</p>
                  <!-- /wp:paragraph -->

                  <table style='height: 246px;' width='662'>
                  <tbody>
                  <tr></tr>
                  <tr>
                  <td> <b>First Air Date</b></td>
                  <td>". $response->first_air_date ."</td>
                  </tr>
                  <tr>
                  <td> <b>Last Air Date</b></td>
                  <td>". $response->last_air_date."</td>
                  </tr>
                  <tr>
                  <td><b>Number of Seasons </b></td>
                  <td>". $response->number_of_seasons."</td>
                  </tr>
                  <tr>
                  <td><b>Number of Episodes</b></td>
                  <td>". $response->number_of_episodes."</td>
                  </tr>
                  <tr>
                  <td><b>Original Name</b></td>
                  <td>". $response->original_name."</td>
                  </tr>
                  <tr>
                  <td><b>Original Language</b></td>
                  <td>". $response->original_language."</td>
                  </tr>
                  <tr>
                  <td><b>Popularity</b></td>
                  <td>". $response->popularity."</td>
                  </tr>
                  <tr>
                  <td><b>Vote Average</b></td>
                  <td>[rating stars='". $response->vote_average."']</td>
                  </tr>
                  <tr>
                  <td><b>Vote Count</b></td>
                  <td>". $response->vote_count."</td>
                  </tr>
                  </tbody>
                  </table>";
      }
      if ($_GET['type'] == 'movie') {
        $__cont ="<!-- wp:heading {'level':3} --><h3>Overview :</h3>
                  <!-- /wp:heading -->
                  <!-- wp:paragraph {'fontSize':'small'} -->
                  <p class='has-small-font-size'>". $response->overview."</p>
                  <!-- /wp:paragraph -->

                  <table style='height: 246px;' width='662'>
                  <tbody>
                  <tr></tr>
                  <tr>
                  <td> <b>First Air Date</b></td>
                  <td>". $response->release_date ."</td>
                  </tr>
                  <tr>
                  <td> <b>First Air Date</b></td>
                  <td>". $response->tagline ."</td>
                  </tr>
                  <tr>
                  <td><b>Number of Episodes</b></td>
                  <td>". $response->runtime."</td>
                  </tr>
                  <tr>
                  <td><b>Original Name</b></td>
                  <td>". $response->original_name."</td>
                  </tr>
                  <tr>
                  <td><b>Original Language</b></td>
                  <td>". $response->original_language."</td>
                  </tr>
                  <tr>
                  <td><b>Popularity</b></td>
                  <td>". $response->popularity."</td>
                  </tr>
                  <tr>
                  <td><b>Vote Average</b></td>
                  <td>[rating stars='". $response->vote_average."']</td>
                  </tr>
                  <tr>
                  <td><b>Vote Count</b></td>
                  <td>". $response->vote_count."</td>
                  </tr>
                  </tbody>
                  </table>";$__cont ="<!-- wp:heading {'level':3} --><h3>Overview :</h3>
                  <!-- /wp:heading -->
                  <!-- wp:paragraph {'fontSize':'small'} -->
                  <p class='has-small-font-size'>". $response->overview."</p>
                  <!-- /wp:paragraph -->

                  <table style='height: 246px;' width='662'>
                  <tbody>
                  <tr></tr>
                  <tr>
                  <td> <b>First Air Date</b></td>
                  <td>". $response->release_date ."</td>
                  </tr>
                  <tr>
                  <td> <b>First Air Date</b></td>
                  <td>". $response->tagline ."</td>
                  </tr>
                  <tr>
                  <td><b>Number of Episodes</b></td>
                  <td>". $response->runtime."</td>
                  </tr>
                  <tr>
                  <td><b>Original Name</b></td>
                  <td>". $response->original_name."</td>
                  </tr>
                  <tr>
                  <td><b>Original Language</b></td>
                  <td>". $response->original_language."</td>
                  </tr>
                  <tr>
                  <td><b>Popularity</b></td>
                  <td>". $response->popularity."</td>
                  </tr>
                  <tr>
                  <td><b>Vote Average</b></td>
                  <td>[rating stars='". $response->vote_average."']</td>
                  </tr>
                  <tr>
                  <td><b>Vote Count</b></td>
                  <td>". $response->vote_count."</td>
                  </tr>
                  </tbody>
                  </table>";
      }

      global $user_ID;
      $new_post = array(
          'post_title' => $response->name,
          'post_content' => $__cont,
          'post_status' => 'publish',
          'post_date' => date('Y-m-d H:i:s'),
          'post_author' => $user_ID,
          'post_type' => 'post',
          'post_category' => $__cat_id__to_post,
      );
      // $post_id = wp_insert_post($new_post);
      // wp_set_post_terms( $post_id, $__cat_id__to_post, 'category', true );
      if( ! is_wp_error( $post_id ) ){
        $ecc = update_post_meta( $post_id, '_thumbnail_id', $return__image_id);
        echo $ecc;
      }

       


      // print("<pre>" . print_r($__re__categories, true) . "</pre>");
      // print("<pre>" . print_r($all_req_category, true) . "</pre>");
      // print("<pre>" . print_r($__cat__mv__name, true) . "</pre>");
    }
    // echo $__single__mv_url;
    echo $response_code;
  } else {
    echo 'none';
  }
}


?>