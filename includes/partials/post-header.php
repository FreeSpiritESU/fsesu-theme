
                <article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
                    <header class='entry-header'>
                        <h2 class='entry-title'>
                            <a href='<?php the_permalink(); ?>' title='<?php printf( 'Permalink to %s', the_title_attribute( 'echo=0' ) ); ?>' rel='bookmark'>
                                <?php the_title(); ?>   
                            </a>
                        </h2>
                        
                        <section class='entry-meta'>
                            <?php do_action( 'entry_meta' ); ?>  
                        </section><!-- .entry-meta -->
                    </header><!-- .entry-header -->