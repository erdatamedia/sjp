<div id="realtime-clock"
     style="display:inline-flex;align-items:center;gap:10px;
            font-size:0.9rem;color:inherit;padding:4px 12px;">
  <span id="clock-date" style="opacity:0.75;font-size:0.82rem;"></span>
  <span id="clock-time"
        style="font-size:1.05rem;font-weight:700;
               font-variant-numeric:tabular-nums;
               letter-spacing:0.05em;min-width:70px;">--:--:--</span>
</div>
<script>
(function() {
  var D = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  var M = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  function pad(n) { return String(n).padStart(2, '0'); }
  function tick() {
    var t = new Date();
    var el_time = document.getElementById('clock-time');
    var el_date = document.getElementById('clock-date');
    if (el_time) el_time.textContent =
      pad(t.getHours()) + ':' + pad(t.getMinutes()) + ':' + pad(t.getSeconds());
    if (el_date) el_date.textContent =
      D[t.getDay()] + ', ' + t.getDate() + ' ' + M[t.getMonth()] + ' ' + t.getFullYear();
  }
  tick();
  setInterval(tick, 1000);
})();
</script>
