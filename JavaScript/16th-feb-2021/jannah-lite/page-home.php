<?php
/**
 * Template Name: Homepage
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

get_header(); ?>

    <div class="main-wrap page-wrap home-wrap" id="site-content">
        <?php if(is_active_sidebar('home-section-1-left')) { ?>
            <div class="section section-1" id="section-1">
                <div class="container">
                    <div class="row">
                        <div class="col big-block">
                            <?php dynamic_sidebar('home-section-1-left'); ?>
                        </div>
                        <?php if(is_active_sidebar('home-section-1-right')) { ?>
                            <div class="col-lg-4">
                                <div class="sticky-sidebar" id="sticky-sidebar-1" data-parent="#section-1">
                                    <div class="sidebar__inner">
                                        <?php dynamic_sidebar('home-section-1-right'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>            
        <?php } ?>
        
        <?php if(is_active_sidebar('home-section-2-left')) { ?>
            <div class="section section-2" id="section-2">
                <div class="container">
                    <div class="row">
                        <div class="col big-block">
                        <?php dynamic_sidebar('home-section-2-left'); ?>
                        </div>
                        <?php if(is_active_sidebar('home-section-2-right')) { ?> 
                            <div class="col-lg-4">
                                <div class="sticky-sidebar" id="sticky-sidebar-2" data-parent="#section-2">
                                    <div class="sidebar__inner">
                                        <?php dynamic_sidebar('home-section-2-right'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if(is_active_sidebar('home-section-3-left')) { ?>
            <div class="section section-3" id="section-3">
                <div class="container">
                    <div class="row">
                        <div class="col big-block">
                        <?php dynamic_sidebar('home-section-3-left'); ?>
                        </div>
                        <?php if(is_active_sidebar('home-section-3-right')) { ?> 
                            <div class="col-lg-4">
                                <div class="sticky-sidebar" id="sticky-sidebar-3" data-parent="#section-3">
                                    <div class="sidebar__inner">
                                        <?php dynamic_sidebar('home-section-3-right'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if(is_active_sidebar('home-section-4-left')) { ?>
            <div class="section section-4" id="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col big-block">
                        <?php dynamic_sidebar('home-section-4-left'); ?>
                        </div>
                        <?php if(is_active_sidebar('home-section-4-right')) { ?> 
                            <div class="col-lg-4">
                                <div class="sticky-sidebar" id="sticky-sidebar-4" data-parent="#section-4">
                                    <div class="sidebar__inner">
                                        <?php dynamic_sidebar('home-section-4-right'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </div>
    
<?php get_footer(); ?>
    
