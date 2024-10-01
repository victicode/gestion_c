import storage from "@/services/storage";

const util = {
  errorLogout: (callback) => {
    storage.deleteItem("is_admin");
    storage.deleteItem("user_unique_id");
    storage.deleteItem("id_token");
    setTimeout(() => {
      callback()
    }, 1000);
    
  }
}

export default util