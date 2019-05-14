<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; {{App\Setting::where('slug','title')->get()->first()->description}} {{date('Y')}}</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
