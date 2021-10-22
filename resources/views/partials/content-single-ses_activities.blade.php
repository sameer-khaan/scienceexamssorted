<article @php post_class() @endphp>
  <div class="full-width">
    <div class="container">
      <div class="row">
        <div class="col-12">
          @php 
            $date = new DateTime();

            $current_month = $date->format("n");
            $current_year = $date->format("Y");

            $current_week = $date->format("W");
            $weekstartdate = new DateTime();
            $weekstartdate->setISODate($current_year, $current_week);
            $week_start = $weekstartdate->format('Y-m-d');

            if($current_month<9) {
              $current_year = $current_year-1;
            }

            $september_date = new DateTime($current_year . "-09-01");
            $september_week = $september_date->format("W");

            $september_week_start = new DateTime();
            $september_week_start->setISODate($current_year, $september_week);
            $september_week_start_format = $september_week_start->format('Y-m-d');

            $current_week = week_between_two_dates($september_week_start_format, $week_start);

            $current_week = $current_week + 1;

            if($current_week == 53) {
              $current_week = 1;
            }
            
            $month_order = array('9', '10', '11', '12', '1', '2', '3', '4', '5', '6', '7', '8');
          @endphp

          <div class="alert alert-info">

            <h3>Current week: Week {{ $current_week }} ({{ $weekstartdate->format('d-m-Y') }})</h3>
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
                <div class="col-12 white-row activity-buttons text-center">
                  @php $select_html = ''; @endphp
                  @foreach ($month_order as $month)
                    @php
                      $dateObj   = DateTime::createFromFormat('d-n-Y', '01-' . $month . '-'.  date('Y'));
                      $monthName = $dateObj->format('F'); // March
                    @endphp
                    <button class="btn btn-white btn-pink-hover mx-3 mt-0 mb-4 d-none d-lg-inline-block {{ $month == $current_month ? 'active' : '' }}" data-month-for="{{$month}}">{{$monthName}}</button>
                    @php
                      if($month == $current_month) {
                        $active = 'selected="selected"';
                      } else {
                        $active = '';
                      }
                      $select_html .= '<option value="'.$month.'" '. $active .' >'.$monthName.'</option>';
                    @endphp
                  @endforeach

                  <label class="d-block d-lg-none button-select-hold">
                    <span class="label">Select Month:</span>
                    <select name="month_select" id="month_select">
                      {!! $select_html !!}
                    </select>
                  </label>
                </div>
                <div class="col-12">
                  @php
                    $user_id = get_current_user_id();
                  @endphp
                  @foreach ($month_order as $month)
                    <div class="large-card month-card {{ $month == $current_month ? 'active' : '' }}" data-month-card="{{$month}}">
                       @php
                        $dateObj   = DateTime::createFromFormat('d-n-Y', '01-' . $month . '-'.  date('Y'));
                        $monthName = $dateObj->format('F'); // March
                      @endphp
                      <h2>{{ $monthName }}</h2>
                      <div class="table-responsive">
                        <table class="table download-table table-striped">
                          <thead>
                            <tr>
                              <th scope="col">Week</th>
                              @if($user_id)
                                <th scope="col">Previously downloaded?</th>
                              @endif
                              <th scope="col text-right"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @for($i = $september_week; $i <= ($september_week+51); $i++)
                              @php
                                $displayed_week_number = $i - ($september_week-1);

                                $dates = getStartAndEndDate($i, $current_year);
                              @endphp

                              @if($dates['week_start_month'] == $month || $dates['week_end_month'] == $month)
                                @if($month!=8 || ($month==8 && $displayed_week_number!=1))
                                  <tr>
                                    <th scope="row">
                                      {{ $displayed_week_number }} (<span class="no-break">{{ $dates['week_start'] }} -</span> <span class="no-break">{{ $dates['week_end'] }}</span>)
                                      @php 
                                        $new = false;
                                        if(get_field('week_'.$displayed_week_number.'_secure_document', get_the_id())) {
                                          if(get_the_date('Y-m-d H:i:s', get_sub_field('week_'.$displayed_week_number.'_secure_document'), get_the_id()) >= date('Y-m-d H:i:s', strtotime("-30 days"))) {
                                            $new = true;
                                          }
                                        }

                                        if(get_field('week_'.$displayed_week_number.'_secure_mark_scheme', get_the_id())) {
                                          if(get_the_date('Y-m-d H:i:s', get_sub_field('week_'.$displayed_week_number.'_secure_mark_scheme'), get_the_id()) >= date('Y-m-d H:i:s', strtotime("-30 days"))) {
                                            $new = true;
                                          }
                                        }
                                      @endphp
                                      @if($new)
                                        <span class="new-badge">new</span>
                                      @endif
                                    </th>
                                    @if($user_id)
                                      <td>
                                        @if(get_field('week_'.$displayed_week_number.'_secure_document', get_the_id()))
                                          @if(get_user_meta($user_id, 'downloaded_' . get_field('week_'.$displayed_week_number.'_secure_document', get_the_id()), true ))
                                            <i class="fas fa-check-circle" style="font-size: 1.3em; color: #c0507f;"></i>
                                          @endif
                                        @endif
                                      </td>
                                    @endif
                                    <td class="text-right">
                                      @if(get_field('week_'.$displayed_week_number.'_secure_document', get_the_id()))
                                        <a href="<?php echo App\get_download_link(get_field('week_'.$displayed_week_number.'_secure_document', get_the_id())); ?>" class="btn btn-text">Activity <i class="fas fa-download"></i></a>
                                      @endif
                                      @if(get_field('week_'.$displayed_week_number.'_secure_mark_scheme', get_the_id()))
                                        <a class="btn btn-text" href="<?php echo App\get_download_link(get_field('week_'.$displayed_week_number.'_secure_mark_scheme', get_the_id())); ?>">Mark scheme <i class="fas fa-download"></i></a>
                                      @endif
                                      @if(!get_field('week_'.$displayed_week_number.'_secure_mark_scheme', get_the_id()) && !get_field('week_'.$displayed_week_number.'_secure_document', get_the_id()))
                                        No resources available
                                      @endif
                                    </td>
                                  </tr>
                                @endif
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
              $ret['week_start'] = $dto->format('d-m-Y');
              $ret['week_start_month'] = $dto->format('n');
              $dto->modify('+6 days');
              $ret['week_end'] = $dto->format('d-m-Y');
              $ret['week_end_month'] = $dto->format('n');
              return $ret;
            }

            function week_between_two_dates($date1, $date2)
            {
              $first = DateTime::createFromFormat('Y-m-d', $date1);
              $second = DateTime::createFromFormat('Y-m-d', $date2);
              if($date1 > $date2) return week_between_two_dates($date2, $date1);
              return floor($first->diff($second)->days/7);
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
        $('#month_select').val(month_for);
        $('.month-card[data-month-card="'+month_for+'"]').slideDown();
      });

      $('#month_select').change(function(event) {
        event.preventDefault();
        val = $(this).val();
        $('[data-month-for="'+val+'"]').trigger('click');
      });
    });
  </script>
@endsection