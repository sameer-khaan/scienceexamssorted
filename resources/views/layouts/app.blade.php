<!DOCTYPE html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="pusher">
      <div class="wrap container" role="document">
        <div class="content">
          <main class="main">
            @include('partials.page-header')
            <div class="page-inner-content">
              @yield('content')
            </div>
          </main>
          @if (App\display_sidebar())
            <aside class="sidebar">
              @include('partials.sidebar')
            </aside>
          @endif
        </div>
      </div>
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
    <script type="text/javascript">
      function decodeHtml(html) {
          var txt = document.createElement("textarea");
          txt.innerHTML = html;
          return txt.value;
      }
    </script>
    @yield('scripts')
    @yield('modals')
    @if(get_field('enable_popup', 'option'))
      <script type="text/javascript">
        jQuery(document).ready(function($) {
          $(window).on('load',function(){
            if (!sessionStorage.getItem('shown-modal')){
              $('#popupModal').modal('show');
              sessionStorage.setItem('shown-modal', 'true');
            }
          });
        });
      </script>
      <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">@php the_field('popup_title', 'option') @endphp</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @php the_field('popup_content', 'option') @endphp
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endif
   <input id="rdwidgeturl" name="rdwidgeturl" value="https://booking.resdiary.com/widget/Standard/MrsSalisburysFamousTeaRooms/16162?includeJquery=true" type="hidden">
   <script type="text/javascript" src="https://booking.resdiary.com/bundles/WidgetV2Loader.js"></script>
  </body>
</html>
