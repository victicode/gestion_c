export default function admin (_to, _from, next) {
  document.title = _to.meta.title + ' - Gestion C'
  const isAuthenticated = window.localStorage.getItem('id_token');
  const isAdmin = window.localStorage.getItem('is_admin');

  if (isAuthenticated && isAdmin == 'true') {
    next();
  } else {
    next({ name: 'dashboard' });
  }
};