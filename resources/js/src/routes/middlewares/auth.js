export default function auth (_to, _from, next) {
  document.title = _to.meta.title + ' - Gestion C'
 const isAuthenticated = window.localStorage.getItem('id_token');
 if (isAuthenticated) {
   next();
 } else {
   next({ name: 'Login' });
 }
};