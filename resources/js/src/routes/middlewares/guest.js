export default function guest (_to, _from, next) {
  document.title = _to.meta.title + ' - Gestion C'
  const isAuthenticated = window.localStorage.getItem('id_token');
  if (isAuthenticated) {
    window.localStorage.getItem('is_admin') ==  '1' 
    ? next({ path: '/admin' }) 
    : window.localStorage.getItem('is_admin') ==  '3' 
    ? next({ path: '/counter' })
    : next({ path: '/host' })

  } else {
   next();
  }
}