@include('emails.layouts.header')

    <section class="py-10">
      <article class="mt-8 text-gray-500 leading-7 tracking-wider">
        {!! $content !!}
        <footer class="mt-12">
          <p>Thanks & Regards,<br>Home Stay</p>
        </footer>
      </article>
    </section>
@include('emails.layouts.footer')
