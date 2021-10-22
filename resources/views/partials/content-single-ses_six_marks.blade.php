<article @php post_class() @endphp>
  <div class="full-width">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="full-width global-padding dark-bg">
            <div class="container">
              <div class="row">
                <div class="col-12 white-row activity-buttons text-center">
                  @php
                    $level = wp_get_post_terms(get_the_id(), 'ses_level');
                    $exam_board = wp_get_post_terms(get_the_id(), 'ses_exam_board');
                    $subject = wp_get_post_terms(get_the_id(), 'ses_subject');
                  @endphp
                  @if($level && $exam_board && !is_wp_error($exam_board) && !is_wp_error($level))
                    @php
                      $exam_board = $exam_board[0]->slug;
                      $level = $level[0]->slug;
                      $subject = $subject[0]->slug;
                    @endphp
                  
                    @php
                      $tax_query = array();
                      $tax_query[] = array(
                          'taxonomy' => 'ses_level',
                          'field'    => 'slug',
                          'terms'    => $level,
                          'operator' => 'IN',
                      );

                      $tax_query[] = array(
                          'taxonomy' => 'ses_exam_board',
                          'field'    => 'slug',
                          'terms'    => $exam_board,
                          'operator' => 'IN',
                      );

                      $tax_query[] = array(
                          'taxonomy' => 'ses_subject',
                          'field'    => 'slug',
                          'terms'    => $subject,
                          'operator' => 'IN',
                      );

                      $args = array(
                          'post_type' => 'ses_six_marks',
                          'posts_per_page' => -1,
                          'orderby' => 'menu_order',
                          'tax_query'  =>  $tax_query
                      );

                      $topics = new \WP_Query( $args );

                      $current_id = get_the_id();
                    @endphp


                    @if ( $topics->have_posts() )
                      @php
                        $select_html = '';
                        $under_card_html = '';
                      @endphp
                      @while ( $topics->have_posts() )
                        @php
                          $topics->the_post();
                          $under_card_html .= '<a href="'.get_the_permalink().'"><h3>' . get_the_title() . ' <small>View topic <i class="fal fa-long-arrow-right"></i></small></h3></a>';
                        @endphp

                        @if(have_rows('questions', get_the_id()))
                          @php
                            $tooltip_html = '<small class="sub-topics"><strong>Questions include:</strong>';
                            $under_card_html .= '<div class="questions-hold">';
                          @endphp
                          @while(have_rows('questions', get_the_id()))
                            @php the_row(); @endphp
                            @php
                              $the_html = '<span>' . get_sub_field('question_label') . '</span>'; 
                              $tooltip_html .= $the_html;
                              $under_card_html .= $the_html;
                            @endphp
                          @endwhile
                          @php
                            $tooltip_html .= '</small>';
                            $under_card_html .= '</div>';
                          @endphp
                        @endif

                         <a href="@php the_permalink() @endphp" class="btn btn-white btn-pink-hover d-none d-xl-inline-block mx-3 mt-0 mb-5 {{ $current_id == get_the_id() ? 'active' : ''}}" data-post-id="{{get_the_id()}}">@php the_title() @endphp</a> 
                         @php
                            if($current_id == get_the_id()) {
                              $active = 'selected="selected"';
                            } else {
                              $active = '';
                            }
                            $select_html .= '<option value="'.get_the_id().'" '. $active .' >'.get_the_title().'</option>';
                         @endphp
                         @section('scripts')
                        @parent
                          <script type="text/javascript">
                            jQuery(document).ready(function($) {
                              $('[data-post-id="{{get_the_id()}}"]').tooltip({
                                title: decodeHtml("{!! htmlentities($tooltip_html, ENT_QUOTES) !!}"),
                                html: true
                              });
                            });
                          </script>
                        @endsection
                      @endwhile

                      <label class="d-block d-xl-none button-select-hold">
                        <span class="label">Select Topic:</span>
                        <select name="topic_select" id="topic_select">
                          {!! $select_html !!}
                        </select>
                      </label>

                    @endif

                    @php
                      wp_reset_postdata();
                    @endphp

                  @endif


                  
                </div>
                <div class="col-12">
                  <div class="large-card">
                    <h2>@php the_title() @endphp</h2>
                    @if(have_rows('questions'))
                      @while(have_rows('questions'))
                        @php the_row(); @endphp
					  	<div class="row align-items-center">
					  	<div class="col-sm-4">
                        <h3>@php the_sub_field('question_label') @endphp</h3>
							</div>
					  <div class="col-sm-8">
                        <div class="button-group mb-4">
                          @if(get_sub_field('secure_question_file'))
                            <a href="<?php echo App\get_download_link(get_sub_field('secure_question_file')); ?>" class="btn btn-primary">
                              Question
                              @if(get_the_date('Y-m-d H:i:s', get_sub_field('secure_question_file')) >= date('Y-m-d H:i:s', strtotime("-30 days")))
                                <span class="new-badge">new</span>
                              @endif
                            </a>
                          @endif
                          @if(get_sub_field('secure_answer_file'))
                            <a href="<?php echo App\get_download_link(get_sub_field('secure_answer_file')); ?>" class="btn btn-primary" class="btn btn-primary">
                              Answer
                              @if(get_the_date('Y-m-d H:i:s', get_sub_field('secure_answer_file')) >= date('Y-m-d H:i:s', strtotime("-30 days")))
                                <span class="new-badge">New!</span>
                              @endif
                            </a>
                          @endif
                        </div>
						  </div>
							 </div>
                      @endwhile
                    @endif
                  </div>
                  <div class="white-row other-topics-hold d-block d-xl-none">
                    <h2>What's in other topics:</h2>
                    {!! $under_card_html !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>

@section('scripts')
  @parent
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#topic_select').change(function(event) {
        event.preventDefault();
        val = $(this).val();
        var href = $('[data-post-id="'+val+'"]').attr('href');
        window.location.href = href;
      });
    });
  </script>
@endsection
