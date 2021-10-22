<article @php post_class() @endphp>
  <div class="full-width">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="full-width global-padding dark-bg">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 text-center no-last-margin white-row">
                  <h2>Free @php the_title(); @endphp learning resources</h2>
                  @php the_field('description') @endphp
                </div>

                <div class="col-12">
                  <div class="full-width white-row">
                    <div class="container">
                      <div class="search-grid">
                        @if( have_rows('resources') )
                          @while( have_rows('resources') )
                            @php the_row(); @endphp
                            <a href="@php the_sub_field('resource_file') @endphp" target="_blank" class="work-card post-card" data-aos="fade-up" data-aos-offset="300" data-aos-duration="1000">
                              <div class="inner-card">
                                <div class="image-hold">
                                  <div class="image">
                                    @if(get_sub_field('image'))
                                      @php
                                        $image_id = get_sub_field('image');
                                      @endphp
                                    @else
                                      @php
                                        $image_id = get_field('no_image', 'option');
                                      @endphp
                                    @endif
                                    <div class="featured">
                                      {!! wp_get_attachment_image($image_id, 'main', false, array('data-object-fit'=>'cover')) !!}
                                    </div>
                                  </div>
                                </div>
                                <div class="inner-text">
                                  <div class="left-text">
                                    <h2>@php the_sub_field('resource_name') @endphp</h2>
                                    @php the_sub_field('description') @endphp
                                    <button class="btn btn-primary">Download</button>
                                  </div>
                                </div>
                              </div>
                            </a>
                          @endwhile
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                {{-- <div class="col-12">
                  <div class="large-card">
                    <table class="table download-table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Title</th>
                          <th scope="col">Description</th>
                          <th scope="col text-right"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @if( have_rows('resources') )
                            @while( have_rows('resources') )
                              @php the_row(); @endphp
                              <tr>
                                <th scope="row" width="30%">@php the_sub_field('resource_name') @endphp</th>
                                <td><div class="no-last-margin" width="50%">@php the_sub_field('description') @endphp</div></td>
                                <td class="text-right" width="20%">
                                  @if(get_sub_field('resource_file'))
                                    <a href="@php the_sub_field('resource_file') @endphp" class="btn btn-text" target="_blank">Download <i class="fas fa-download"></i></a>
                                  @endif
                                </td>
                              </tr>
                            @endwhile
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div> --}}

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
