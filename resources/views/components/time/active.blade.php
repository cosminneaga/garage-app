@props(['start'])

<div class="flex justify-start gap-3">
    <div class="beacon"><span></span></div>
    <p class="text-success text-2xl font-bold">Active Time: <span id="active-time"></span></p>
    <div class="beacon"><span></span></div>
</div>

<script type="module">
    const start = @js(Carbon::parse($start));
    const element = document.getElementById('active-time');
    element.innerText = window.moment(start).fromNow(true);

    setInterval(() => {
        element.innerText = window.moment(start).fromNow(true);
    }, 5000);
</script>
