<?php
get_header(); ?>
<section class="success-hero">
  <div class="sub-contents">
    <h2 class="section-headline">Customer Success Stories</h2>
  </div>
</section>
<section class="success-archive">
  <div class="sub-contents" id="form">
    <div class="filter-section">
      <form data-js-form="filter">
        <div>
          <label for="">Search</label>
          <input type="text" id="search" name="search">
        </div>

        <div>
          <?php
          $args = array(
            'type'                     => 'success-stories',
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hierarchical'             => 1,
            'taxonomy'                 => 'solutions_categories',
          );
          $categories = get_categories($args);
          echo '<label>Choose Solution</label><select name="solution" id="solution"> <option value="" selected>All</option>';

          foreach ($categories as $category) {
            $url = get_term_link($category); ?>
           
            <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
          <?php
          }
          echo '</select>';
          ?>
        </div>

        <div>
          <?php
          $args = array(
            'type'                     => 'success-stories',
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hierarchical'             => 1,
            'taxonomy'                 => 'industry_categories',
          );
          $categories = get_categories($args);
          echo '<label>Choose Industry</label><select name="industry" id="industry"><option value="" selected>All</option>';

          foreach ($categories as $category) {
            $url = get_term_link($category); ?>
            
            <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
          <?php
          }
          echo '</select>';
          ?>
        </div>
        <!-- <button class="gform_button button" type="submit">Filter</button> -->
      </form>
    </div>
    <div class="response-section">
      <div id="response-content">
        <div class="lds-roller">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
      <div id="paginate"></div>
    </div>
  </div>
</section>
<?php get_footer(); ?>