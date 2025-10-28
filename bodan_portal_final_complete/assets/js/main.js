// main.js - fetch announcements via simple AJAX (demo)
window.addEventListener('DOMContentLoaded', ()=>{
  const el = document.getElementById('news-list');
  if(!el) return;
  fetch('admin/get_announcements.php').then(r=>r.json()).then(data=>{
    if(!data || data.length===0) el.innerHTML = '<p>No announcements yet.</p>';
    else {
      el.innerHTML = data.map(a=>`<article class="card"><h3>${a.title}</h3><p>${a.body.substring(0,160)}...</p><small>${a.created_at}</small></article>`).join('');
    }
  }).catch(e=>{ el.innerHTML = '<p>Error loading news</p>'; });
});