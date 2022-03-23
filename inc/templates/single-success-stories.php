<?php
get_header(); ?>
<section class="success-hero" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
  <div class="sub-contents">
    <?php if (get_field('company_logo')) : ?>
    <div class="hero-logo-image">
      <img src="<?php echo get_field('company_logo')['url']; ?>" />
    </div>
    <?php endif; ?>
    <h2 class="section-headline">
      <?php the_title(); ?>
    </h2>
    <h4 class="company-name">
      <?php the_field('company_name'); ?>
    </h4>
    <?php if (get_field('case_study_pdf')) : ?>
    <a href="<?php echo get_field('case_study_pdf')['url']; ?>" class="button-outline" target="_blank">CASE STUDY (PDF)</a>
    <?php endif; ?>
  </div>
</section>
<section class="main-content ">
  <div class="sub-contents">
    <?php the_field('content'); ?>
  </div>
</section>

<section class="testimonial">
  <div class="sub-contents">
    <div class="testimonial-wrapper">
      <div class="right-line-quote">
        <?php if (get_field('testimonial')['testimonial_image']['url']) { $nopadding = true; ?>
        <div class="testimonial-image">
          <img src="<?php echo get_field('testimonial')['testimonial_image']['url']; ?>" alt="">
        </div>
        <?php } ?>
        <div class="content-right" >
          <div class="testimonial-content <?php if($nopadding) {echo 'no-padding';} ?>">
            <?php echo get_field('testimonial')['testimonial_content']; ?>
          </div>
          <div class="testimonial-source">
            <?php echo get_field('testimonial')['testimonial_source']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php get_footer(); ?>