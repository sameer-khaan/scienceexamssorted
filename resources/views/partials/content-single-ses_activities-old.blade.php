<article @php post_class() @endphp>
  <div class="full-width">
    <div class="container">
      <div class="row">
        <div class="col-12">
          @php 
            $date = new DateTime();
            $current_week = $date->format("W");
            $current_month = $date->format("n");
            $dto = new DateTime();
            $dto->setISODate($date->format("Y"), $current_week);
            $ret['week_start'] = $dto->format('jS M Y');
            $month_order = array('9', '10', '11', '12', '1', '2', '3', '4', '5', '6', '7', '8');
            $first_day_week_number = DateTime::createFromFormat('Y-m-d', $date->format("Y-09-01"));
            $first_day_week_number = $first_day_week_number->format("W");

            echo $first_day_week_number;
          @endphp

          <div class="alert alert-info">
            <h3>Current week: Week {{ $current_week }} ({{$ret['week_start']}})</h3>
            <div class="button-hold">
              @if(get_field('week_'.$current_week.'_secure_document', get_the_id()))
                <a href="<?php echo App\get_download_link(get_field('week_'.$current_week.'_secure_document', get_the_id())); ?>" class="btn btn-primary">Download activity</a>
              @endif
              @if(get_field('week_'.$current_week.'_secure_mark_scheme', get_the_id()))
                <a href="<?php echo App\get_download_link(get_field('week_'.$current_week.'_secure_mark_scheme', get_the_id())); ?>" class="btn btn-primary">Download mark scheme</a>
              @endif
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="block-padding"></div>
        </div>

        <div class="col-12">
          <div class="full-width global-padding dark-bg">
            <div class="container">
              <div class="row">
                <div class="col-12 white-row text-center">
                  <h2>See all activities</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-4 col-lg-3 col-xl-2 white-row activity-buttons">
                  @foreach ($month_order as $month)
                    @php
                      $dateObj   = DateTime::createFromFormat('!m', $month);
                      $monthName = $dateObj->format('F'); // March
                    @endphp
                    <button class="btn btn-white btn-pink-hover btn-full {{ $month == $current_month ? 'active' : '' }}" data-month-for="{{$month}}">{{$monthName}}</button>
                  @endforeach
                </div>
                <div class="col-12 col-md-8 col-lg-9 col-xl-10">
                  @foreach ($month_order as $month)
                    <div class="large-card month-card {{ $month == $current_month ? 'active' : '' }}" data-month-card="{{$month}}">
                      @php
                        $monthObject = DateTime::createFromFormat('!m', $month);
                        $month_number = $monthObject->format('m');

                        $dateObj   = DateTime::createFromFormat('Y-m-d', $date->format("Y-" . $month_number . '-01'));
                        $monthName = $dateObj->format('F');
                        
                        $firstOfMonth = $dateObj->format('Y-m-01');
                        $lastOfMonth = $dateObj->format('Y-m-t');

                        $first_week_of_month = DateTime::createFromFormat('Y-m-d', $firstOfMonth);
                        $first_week_of_month = intval($first_week_of_month->format("W"));

                        if($first_week_of_month <= $first_day_week_number) {
                          $first_week_of_month = $first_week_of_month - ($first_day_week_number - 1);
                        }

                        $last_week_of_month = DateTime::createFromFormat('Y-m-d', $lastOfMonth);
                        $last_week_of_month =  intval($last_week_of_month->format("W"));

                      @endphp
                      <h2>{{ $monthName }}</h2>
                      <div class="table-responsive">
                        <table class="table download-table table-striped">
                          <thead>
                            <tr>
                              <th scope="col">Week</th>
                              <th scope="col">Previously downloaded?</th>
                              <th scope="col text-right"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @for($i = $first_week_of_month; $i <= $last_week_of_month; $i++)
                              @php 
                                $week_array = getStartAndEndDate($i, $dateObj->format('Y'))
                              @endphp
                              @if($i != 53)
                                <tr>
                                  <th scope="row">{{ $i }} (<span class="no-break">{{ $week_array['week_start'] }} -</span> <span class="no-break">{{ $week_array['week_end'] }}</span>)</th>
                                  <td></td>
                                  <td class="text-right">
                                    @if(get_field('week_'.$i.'_secure_document', get_the_id()))
                                      <a href="<?php echo App\get_download_link(get_field('week_'.$i.'_secure_document', get_the_id())); ?>" class="btn btn-text">Activity <i class="fas fa-download"></i></a>
                                    @endif
                                    @if(get_field('week_'.$i.'_secure_mark_scheme', get_the_id()))
                                      <a class="btn btn-text" href="<?php echo App\get_download_link(get_field('week_'.$i.'_secure_mark_scheme', get_the_id())); ?>">Mark scheme <i class="fas fa-download"></i></a>
                                    @endif
                                    @if(!get_field('week_'.$i.'_secure_mark_scheme', get_the_id()) && !get_field('week_'.$i.'_secure_document', get_the_id()))
                                      No resources available
                                    @endif
                                  </td>
                                </tr>
                              @endif
                            @endfor
                          </tbody>
                        </table>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

          @php

            function getStartAndEndDate($week, $year) {
              $dto = new DateTime();
              $dto->setISODate($year, $week);
              $ret['week_start'] = $dto->format('Y-m-d');
              $dto->modify('+6 days');
              $ret['week_end'] = $dto->format('Y-m-d');
              return $ret;
            }

          @endphp

         {{--  @for ($week = 1; $week <= 53; $week++)
            <pre>
            @php
              $week_array = getStartAndEndDate($week,2014);
              print_r($week_array);
            @endphp
          </pre>
          @endfor --}}

          

          {{-- @for ($week = 1; $week <= 52; $week++)
            {{ $week }} - {{ $current_week }}
          @endfor --}}
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
      $('[data-month-for]').click(function(event) {
        event.preventDefault();
        $('.month-card').slideUp();
        $('[data-month-for]').removeClass('active');
        $(this).addClass('active');
        var month_for = $(this).attr('data-month-for');
        $('.month-card[data-month-card="'+month_for+'"]').slideDown();
      });
    });
  </script>
@endsection