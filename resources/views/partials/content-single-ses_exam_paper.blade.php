<article @php post_class() @endphp>
  <div class="full-width">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="full-width global-padding dark-bg">
            <div class="container">
              <div class="row">
                <div class="col-12 white-row activity-buttons text-center ">
                  @if(have_rows('topics'))
                    @php $topicid = 0; @endphp
                    @php
                      $select_html = '';
                      $under_card_html = '';
                    @endphp
                    @while(have_rows('topics'))
                      @php
                        the_row();
                        $under_card_html .= '<h3 data-title-topic-for="'.$topicid.'">' . get_sub_field('topic_name') . ' <small>View topic <i class="fal fa-long-arrow-right"></i></small></h3>';
                      @endphp
                      @if(have_rows('sub_topics'))
                          @php
                            $tooltip_html = '<small class="sub-topics"><strong>Topics include:</strong>';
                            $under_card_html .= '<div class="questions-hold">';
                          @endphp
                          @while(have_rows('sub_topics'))
                            @php the_row(); @endphp
                            @php
                              $the_html = '<span>' . get_sub_field('sub_topic_name') . '</span>'; 
                              $tooltip_html .= $the_html;
                              $under_card_html .= $the_html;
                            @endphp
                          @endwhile
                        @php
                          $tooltip_html .= '</small>';
                          $under_card_html .= '</div>';
                        @endphp
                      @endif
                      <button class="btn btn-white btn-pink-hover hello mx-3 mt-0 mb-4 d-none d-lg-inline-block {{ $topicid == '0' ? 'active' : '' }}" data-topic-for="{{$topicid}}">@php the_sub_field('topic_name') @endphp</button>
                      @section('scripts')
                        @parent
                        <script type="text/javascript">
                          jQuery(document).ready(function($) {
                            $('[data-topic-for="{{$topicid}}"]').tooltip({
                              title: decodeHtml("{!! htmlentities($tooltip_html, ENT_QUOTES) !!}"),
                              html: true
                            });
                          });
                        </script>
                      @endsection
                      @php
                        if($topicid == 0) {
                          $active = 'selected="selected"';
                        } else {
                          $active = '';
                        }
                        $select_html .= '<option value="'.$topicid.'" '. $active .' >'.get_sub_field('topic_name').'</option>';
                      @endphp
                      @php $topicid++ @endphp
                    @endwhile
                    <label class="d-block d-xl-none button-select-hold">
                      <span class="label">Select Topic:</span>
                      <select name="topic_select" id="topic_select">
                        {!! $select_html !!}
                      </select>
                    </label>
                  @endif
                </div>
                <div class="col-12">
                  @if(have_rows('topics'))
                    @php $topicid = 0; @endphp
                    @while(have_rows('topics'))
                     @php the_row() @endphp
                      <div class="large-card" {!! $topicid == 0 ? '' : 'style="display: none;"' !!} data-topic-card="{{$topicid}}">
                        <h2>@php the_sub_field('topic_name') @endphp</h2>
                        @if(have_rows('sub_topics'))
                          @while(have_rows('sub_topics'))
                            @php the_row(); @endphp
						  <div class="row align-items-center">
						   <div class="col-sm-4">
                            <h3>@php the_sub_field('sub_topic_name') @endphp</h3>								   
							   </div>
						  <div class="col-sm-8">
                            <div class="button-group mb-4">
                              @if(get_sub_field('secure_notes_file'))
                                <a href="<?php echo App\get_download_link(get_sub_field('secure_notes_file')); ?>" class="btn btn-primary">
                                  Notes
                                  @if(get_the_date('Y-m-d H:i:s', get_sub_field('secure_notes_file')) >= date('Y-m-d H:i:s', strtotime("-30 days")))
                                    <span class="new-badge">new</span>
                                  @endif
                                </a>
                              @endif
                              @if(get_sub_field('secure_questions'))
                                <a href="<?php echo App\get_download_link(get_sub_field('secure_questions')); ?>" class="btn btn-primary" class="btn btn-primary">
                                  Questions
                                  @if(get_the_date('Y-m-d H:i:s', get_sub_field('secure_questions')) >= date('Y-m-d H:i:s', strtotime("-30 days")))
                                    <span class="new-badge">new</span>
                                  @endif
                                </a>
                              @endif
                              @if(get_sub_field('secure_mark_scheme'))
                                <a href="<?php echo App\get_download_link(get_sub_field('secure_mark_scheme')); ?>" class="btn btn-primary" class="btn btn-primary">
                                  Mark Scheme
                                  @if(get_the_date('Y-m-d H:i:s', get_sub_field('secure_mark_scheme')) >= date('Y-m-d H:i:s', strtotime("-30 days")))
                                    <span class="new-badge">new</span>
                                  @endif
                                </a>
                              @endif
                            </div>
							   </div>
						  </div>
                          @endwhile
                        @endif
                      </div>
                      @php $topicid++ @endphp
                    @endwhile
                    <div class="white-row other-topics-hold d-block d-xl-none">
                      <h2>What's in other topics:</h2>
                      {!! $under_card_html !!}
                    </div>
                  @endif
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
      $('[data-topic-for]').click(function(event) {
        event.preventDefault();
        $('.large-card').slideUp();
        $('[data-topic-for]').removeClass('active');
        $(this).addClass('active');
        var topic_for = $(this).attr('data-topic-for');
        $('#topic_select').val(topic_for);
        $('.large-card[data-topic-card="'+topic_for+'"]').slideDown();
      });

      $('#topic_select').change(function(event) {
        event.preventDefault();
        val = $(this).val();
        $('[data-topic-for="'+val+'"]').trigger('click');
      });

      $('[data-title-topic-for]').click(function(event) {
        event.preventDefault();
        val = $(this).attr('data-title-topic-for');
        $('[data-topic-for="'+val+'"]').trigger('click');
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".activity-buttons").offset().top
        }, 500);
      });
    });
  </script>
@endsection
