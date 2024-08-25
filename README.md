# Order Management

Bu projede, ürün, kategori, sipariş, yazar ve kampanya yönetimi için API'ler geliştirilmiştir. API'ler, kullanıcıların oturum açma, kayıt olma, ürün arama ve sipariş oluşturma gibi işlemleri yapmasına olanak tanır.

## Kurulum

Proje, Laravel framework'ü kullanılarak geliştirilmiştir. Aşağıdaki adımları izleyerek projeyi yerel ortamınıza kurabilirsiniz:

### Gereksinimler

- PHP >= 8.0
- Composer
- MySQL
- Laravel >= 10.0

### Adımlar
1. **Depoyu klonlayın:**

    ```bash
    (https://github.com/yahyaBir/order-management-api.git)

2. **Gerekli bağımlılıkları yükleyin:**

    ```bash
    composer install
    ```

3. **Çevre dosyasını oluşturun ve düzenleyin:**

    `.env` dosyasını açın ve veritabanı yapılandırmasını yapın:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=order_management_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

# AuthController API
AuthController, kullanıcı kimlik doğrulama işlemleri için API uç noktaları sağlar. Bu uç noktalar kullanıcıların oturum açmasını, kaydolmasını, çıkış yapmasını, token yenilemesini ve kullanıcı bilgilerini almasını sağlar.

## Kullanıcı Girişi

URL:
/api/v1/login

Method:
POST

URL Params:
Yok

Data Params:
{
  "email": "string (zorunlu)",
  "password": "string (zorunlu)"
}

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Giriş başarılı",
  "access_token": "JWT_TOKEN",
  "token_type": "bearer",
  "expires_in": 3600
}

Hata Yanıtı:
Kod: 401 Unauthorized
İçerik:
{
  "status": "error",
  "message": "E-posta veya şifre hatalı.",
  "detail": "E-posta ve şifrenizin doğru olduğundan emin olun.",
  "error_code": "INVALID_CREDENTIALS",
  "timestamp": "2024-08-25T14:30:00",
  "path": "/api/v1/login"
}
OR

Kod: 422 Unprocessable Entity
İçerik:
{
  "status": "error",
  "message": "Doğrulama başarısız. Lütfen giriş bilgilerinizi kontrol edin.",
  "errors": {
    "email": ["E-posta alanı gereklidir."],
    "password": ["Şifre alanı gereklidir."]
  },
  "timestamp": "2024-08-25T14:30:00",
  "path": "/api/v1/login"
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/login" \
     -H "Content-Type: application/json" \
     -d '{"email": "user@example.com", "password": "password123"}'
     
Notlar:
E-posta ve şifrenin doğru formatta girildiğinden emin olun.
Yanıtları düzgün şekilde işlemek için hata kodlarını kontrol edin.
Giriş başarılı olduğunda, JWT token'ınızı saklamayı unutmayın.

## Kayıt Ol
URL:
/api/v1/register

Method:
POST

URL Params:
Yok

Data Params:
{
  "name": "string (zorunlu)",
  "email": "string (zorunlu)",
  "password": "string (zorunlu)"
}

Başarı Yanıtı:
Kod: 201 Created
İçerik:
{
  "status": "success",
  "message": "Kullanıcı başarıyla kaydedildi",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@example.com"
  },
  "timestamp": "2024-08-25T14:30:00"
}

Hata Yanıtı:
Kod: 422 Unprocessable Entity
İçerik:
{
  "status": "error",
  "message": "Doğrulama başarısız. Lütfen giriş bilgilerinizi kontrol edin.",
  "errors": {
    "name": ["Ad alanı gereklidir."],
    "email": ["E-posta alanı gereklidir.", "E-posta zaten alınmış."],
    "password": ["Şifre alanı gereklidir."]
  },
  "timestamp": "2024-08-25T14:30:00",
  "path": "/api/v1/register"
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/register" \
     -H "Content-Type: application/json" \
     -d '{"name": "John Doe", "email": "john.doe@example.com", "password": "password123"}'
     
Notlar:
Kayıt işlemi sırasında e-posta adresinin daha önce kullanılmadığından emin olun.
Şifre uzunluğu en az 6 karakter olmalıdır.

## Çıkış Yap
URL:
/api/v1/logout

Method:
POST

URL Params:
Yok

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Kullanıcı başarıyla çıkış yaptı.",
  "user": {
    "id": 1,
    "username": "John Doe"
  },
  "timestamp": "2024-08-25T14:30:00"
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/logout" \
     -H "Authorization: Bearer YOUR_ACCESS_TOKEN"
     
Notlar:
Çıkış yaparken geçerli bir JWT token sağlamanız gerekmektedir.
Çıkış yaptıktan sonra token geçersiz hale gelir.

## Token Yenile
URL:
/api/v1/refresh

Method:
POST

URL Params:
Yok

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Giriş başarılı",
  "access_token": "NEW_JWT_TOKEN",
  "token_type": "bearer",
  "expires_in": 3600
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/refresh" \
     -H "Authorization: Bearer YOUR_REFRESH_TOKEN"
     
Notlar:
Yenileme işlemi için geçerli bir refresh token sağlamanız gerekmektedir.
Token yenileme işlemi başarılı olduğunda, yeni bir JWT token alırsınız.

## Kullanıcı Bilgilerini Al
URL:
/api/v1/user

Method:
GET

URL Params:
Yok

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "id": 1,
  "name": "John Doe",
  "email": "john.doe@example.com"
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/user" \
     -H "Authorization: Bearer YOUR_ACCESS_TOKEN"
     
Notlar:
Kullanıcı bilgilerini alabilmek için geçerli bir JWT token sağlamanız gerekmektedir.



# CategoryController API
CategoryController, kategori yönetimi için API uç noktaları sağlar. Bu uç noktalar kategorilerin listelenmesini, görüntülenmesini, oluşturulmasını, güncellenmesini ve silinmesini sağlar.

##Kategori Listesi
URL:
/api/v1/categories

Method:
GET

URL Params:
Yok

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "data": [
      {
        "id": 1,
        "title": "Category 1",
      },
      {
        "id": 2,
        "title": "Category 2",
      }
  ]
}      

Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "No categories found in the current page of results."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/categories"

Notlar:
Sayfalama kullanılır, döndürülen veriler sayfa numarası ve diğer sayfalama bilgilerini içerir.

##Kategori Görüntüle
URL:
/api/v1/categories/{id}

Method:
GET

URL Params:
Required:id=[integer]

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "category": {
    "id": 1,
    "title": "Category 1",
  }
}

Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "Category not found."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/categories/1"

Notlar:
Kategori mevcut değilse, 404 hatası döner.

## Kategori Oluştur
URL:
/api/v1/categories

Method:
POST

URL Params:
Yok

Data Params:
{
  "title": "string (zorunlu)"
}

Başarı Yanıtı:
Kod: 201 Created
İçerik:
{
  "status": "success",
  "message": "Category successfully created",
  "data": {
    "id": 1,
    "title": "New Category",
  }
}

Hata Yanıtı:
Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."]
  }
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/categories" \
     -H "Content-Type: application/json" \
     -d '{"title": "New Category"}'
     
Notlar:
Kategori başlığı benzersiz olmalıdır.
Geçerli bir başlık girilmelidir.

## Kategori Güncelle
URL:
/api/v1/categories/{id}

Method:
PUT

URL Params:
Required:id=[integer]

Data Params:
json
{
  "title": "string (zorunlu)"
}

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Category updated successfully",
  "data": {
    "id": 1,
    "title": "Updated Category",
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."]
  }
}

OR

Kod: 500 Internal Server Error
İçerik:
{
  "status": "error",
  "message": "An unexpected error occurred: {error_message}"
}

Örnek Çağrı:
curl -X PUT "http://127.0.0.1:8000/api/v1/categories/1" \
     -H "Content-Type: application/json" \
     -d '{"title": "Updated Category"}'
     
Notlar:
Kategori başlığı benzersiz olmalıdır.

## Kategori Sil
URL:
/api/v1/categories/{id}

Method:
DELETE

URL Params:
Required:id=[integer]

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK

İçerik:
{
  "status": "success",
  "message": "Category with ID {id} successfully deleted"
}

Örnek Çağrı:
curl -X DELETE "http://127.0.0.1:8000/api/v1/categories/1"
Notlar:

Silinen kategori ID'si ile geri dönecek bilgiye dikkat edin.
Kategori mevcut değilse veya silinemiyorsa, uygun hata yanıtı dönecektir.



  # AuthorController API
AuthorController, yazar yönetimi için API uç noktaları sağlar. Bu uç noktalar yazarların listelenmesini, görüntülenmesini, oluşturulmasını, güncellenmesini ve silinmesini sağlar.

## Yazar Listesi
URL:
/api/v1/authors

Method:
GET

URL Params:
Yok

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "authors": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Author Name",
        "author_origin": "local",
        "created_at": "2024-08-25T14:30:00",
        "updated_at": "2024-08-25T14:30:00"
      },
      ...
    ],
    "first_page_url": "http://127.0.0.1:8000/api/v1/authors?page=1",
    "last_page_url": "http://127.0.0.1:8000/api/v1/authors?page=10",
    ...
  }
}

Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "No authors found in the current page of results."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/authors"

Notlar:
Sayfalama kullanılır, döndürülen veriler sayfa numarası ve diğer sayfalama bilgilerini içerir.

## Yazar Görüntüle
URL:
/api/v1/authors/{id}

Method:
GET

URL Params:
Required:id=[integer]

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK

İçerik:
{
  "status": "success",
  "author": {
    "id": 1,
    "name": "Author Name",
    "author_origin": "local",
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "Author with ID {id} not found."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/authors/1"

Notlar:
Yazar mevcut değilse, 404 hatası döner.

## Yazar Oluştur
URL:
/api/v1/authors

Method:
POST

URL Params:
Yok

Data Params:
{
  "name": "string (zorunlu)",
  "author_origin": "string (zorunlu, 'local' veya 'foreign')"
}

Başarı Yanıtı:
Kod: 201 Created
İçerik:
{
  "status": "success",
  "message": "Author successfully created",
  "data": {
    "id": 1,
    "name": "New Author",
    "author_origin": "local",
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "name": ["The name field is required."],
    "author_origin": ["The author origin field is required."]
  }
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/authors" \
     -H "Content-Type: application/json" \
     -d '{"name": "New Author", "author_origin": "local"}'
     
Notlar:
Yazar adı benzersiz olmalıdır.
Yazar kökeni yalnızca 'local' veya 'foreign' olabilir.

## Yazar Güncelle
URL:
/api/v1/authors/{id}

Method:
PUT

URL Params:
Required:id=[integer]

Data Params:
{
  "name": "string (isteğe bağlı)",
  "author_origin": "string (isteğe bağlı, 'local' veya 'foreign')"
}

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Author updated successfully",
  "data": {
    "id": 1,
    "name": "Updated Author",
    "author_origin": "foreign",
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "name": ["The name field is invalid."],
    "author_origin": ["The author origin field is invalid."]
  }
}

OR

Kod: 500 Internal Server Error
İçerik:
{
  "status": "error",
  "message": "An unexpected error occurred: {error_message}"
}

Örnek Çağrı:
curl -X PUT "http://127.0.0.1:8000/api/v1/authors/1" \
     -H "Content-Type: application/json" \
     -d '{"name": "Updated Author", "author_origin": "foreign"}'
     
Notlar:
Yazar adı benzersiz olmalıdır.
Yazar kökeni yalnızca 'local' veya 'foreign' olabilir.

## Yazar Sil
URL:
/api/v1/authors/{id}

Method:
DELETE

URL Params:
Required:id=[integer]

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Author with ID {id} successfully deleted"
}

Örnek Çağrı:
curl -X DELETE "http://127.0.0.1:8000/api/v1/authors/1"

Notlar:
Silinen yazar ID'si ile geri dönecek bilgiye dikkat edin.
Yazar mevcut değilse veya silinemiyorsa, uygun hata yanıtı dönecektir.



  # ProductController API
ProductController, ürün yönetimi için API uç noktaları sağlar. Bu uç noktalar ürünlerin listelenmesini, görüntülenmesini, oluşturulmasını, güncellenmesini ve silinmesini sağlar.

## Ürün Listesi

URL:
/api/v1/products

Method:
GET

URL Params:
Yok

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK

İçerik:
{
  "status": "success",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Product Title",
        "list_price": 100.00,
        "category_id": 1,
        "author_id": 1,
        "stock_quantity": 50,
        "created_at": "2024-08-25T14:30:00",
        "updated_at": "2024-08-25T14:30:00"
      },
      ...
    ],
    "first_page_url": "http://127.0.0.1:8000/api/v1/products?page=1",
    "last_page_url": "http://127.0.0.1:8000/api/v1/products?page=10",
    ...
  }
}

Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "No products found in the current page of results."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/products"

Notlar:
Sayfalama kullanılır; döndürülen veriler sayfa numarası ve diğer sayfalama bilgilerini içerir.

##Ürün Görüntüle

URL:
/api/v1/products/{id}

Method:
GET

URL Params:
Required:id=[integer]

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK

İçerik:
{
  "status": "success",
  "data": {
    "id": 1,
    "title": "Product Title",
    "list_price": 100.00,
    "category_id": 1,
    "author_id": 1,
    "stock_quantity": 50,
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "Product with ID {id} not found."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/products/1"

Notlar:
Ürün mevcut değilse, 404 hatası döner.

## Ürün Oluştur
URL:
/api/v1/products

Method:
POST

URL Params:
Yok

Data Params:
{
  "title": "string (zorunlu)",
  "list_price": "numeric (zorunlu)",
  "category_id": "numeric (zorunlu, categories tablosunda mevcut olmalı)",
  "author_id": "numeric (zorunlu, authors tablosunda mevcut olmalı)",
  "stock_quantity": "numeric (zorunlu)"
}

Başarı Yanıtı:
Kod: 201 Created
İçerik:
{
  "status": "success",
  "message": "Product successfully created",
  "data": {
    "id": 1,
    "title": "New Product",
    "list_price": 100.00,
    "category_id": 1,
    "author_id": 1,
    "stock_quantity": 50,
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."],
    "list_price": ["The list price field is required."],
    "category_id": ["The selected category_id is invalid."],
    "author_id": ["The selected author_id is invalid."],
    "stock_quantity": ["The stock quantity field is required."]
  }
}
OR

Kod: 500 Internal Server Error

İçerik:
{
  "status": "error",
  "message": "An unexpected error occurred: {error_message}"
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/products" \
     -H "Content-Type: application/json" \
     -d '{"title": "New Product", "list_price": 100.00, "category_id": 1, "author_id": 1, "stock_quantity": 50}'
     
Notlar:
Ürün başlığı benzersiz olmalıdır.
Kategori ve yazar ID'leri mevcut olmalıdır.

## Ürün Güncelle
URL:
/api/v1/products/{id}

Method:
PUT

URL Params:
Required:id=[integer]

Data Params:
{
  "title": "string (isteğe bağlı)",
  "list_price": "numeric (isteğe bağlı)",
  "category_id": "numeric (isteğe bağlı, categories tablosunda mevcut olmalı)",
  "author_id": "numeric (isteğe bağlı, authors tablosunda mevcut olmalı)",
  "stock_quantity": "numeric (isteğe bağlı)"
}

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Product updated successfully",
  "data": {
    "id": 1,
    "title": "Updated Product",
    "list_price": 120.00,
    "category_id": 1,
    "author_id": 1,
    "stock_quantity": 60,
    "created_at": "2024-08-25T14:30:00",
    "updated_at": "2024-08-25T14:30:00"
  }
}

Hata Yanıtı:
Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is invalid."],
    "list_price": ["The list price field is invalid."],
    "category_id": ["The selected category_id is invalid."],
    "author_id": ["The selected author_id is invalid."],
    "stock_quantity": ["The stock quantity field is invalid."]
  }
}
OR

Kod: 500 Internal Server Error

İçerik:
{
  "status": "error",
  "message": "An unexpected error occurred: {error_message}"
}

Örnek Çağrı:
curl -X PUT "http://127.0.0.1:8000/api/v1/products/1" \
     -H "Content-Type: application/json" \
     -d '{"title": "Updated Product", "list_price": 120.00, "category_id": 1, "author_id": 1, "stock_quantity": 60}'
Notlar:

Ürün başlığı benzersiz olmalıdır.
Kategori ve yazar ID'leri mevcut olmalıdır.

## Ürün Sil
URL:
/api/v1/products/{id}

Method:
DELETE

URL Params:
Required:id=[integer]

Data Params:
Yok

Başarı Yanıtı:
Kod: 200 OK
İçerik:
{
  "status": "success",
  "message": "Product with ID {id} successfully deleted"
}
Hata Yanıtı:
Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "Product with ID {id} not found."
}

Örnek Çağrı:
curl -X DELETE "http://127.0.0.1:8000/api/v1/products/1"

Notlar:
Ürün mevcut değilse, 404 hatası döner.


///////////////////////////////////////////////////////////////////////////

  # OrderController API
OrderController, sipariş yönetimi için API uç noktaları sağlar. Bu uç noktalar siparişlerin listelenmesini, görüntülenmesini, oluşturulmasını ve silinmesini sağlar.

## Sipariş Listesi
URL: /api/v1/orders

Method: GET

URL Params: Yok

Data Params: Yok

Başarı Yanıtı: Kod: 200 OK

İçerik:
{
  "status": "success",
  "message": "Orders retrieved successfully.",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "user_id": 1,
        "items": [
          {
            "productId": 1,
            "quantity": 2
          }
        ],
        "order_amount": 200.00,
        "discounted_amount": 190.00,
        "shipping_cost": 10.00,
        "total_amount": 200.00,
        "applied_campaign": "5% discount for orders over 200 TL",
        "status": "pending"
      }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/v1/orders?page=1",
    "last_page_url": "http://127.0.0.1:8000/api/v1/orders?page=10",
    ...
  }
}

Hata Yanıtı: Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "No orders found."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/orders"
Notlar: Sayfalama kullanılır; döndürülen veriler sayfa numarası ve diğer sayfalama bilgilerini içerir.

## Sipariş Görüntüle
URL: /api/v1/orders/{id}

Method: GET

URL Params: Required: id=[integer]

Data Params: Yok

Başarı Yanıtı: Kod: 200 OK

İçerik:
{
  "status": "success",
  "data": {
    "orderId": 1,
    "items": [
      {
        "productId": 1,
        "productName": "Product Title",
        "authorName": "Author Name",
        "authorOrigin": "Author Origin",
        "categoryTitle": "Category Title",
        "price": 100.00,
        "quantity": 2
      }
    ],
    "orderAmount": 200.00,
    "shippingCost": 10.00,
    "discountedAmount": 190.00,
    "appliedCampaign": "5% discount for orders over 200 TL",
    "totalAmount": 200.00,
    "status": "pending"
  }
}

Hata Yanıtı: Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "The requested order could not be found."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/orders/1"
Notlar: Sipariş mevcut değilse, 404 hatası döner.

## Sipariş Oluştur
URL: /api/v1/orders

Method: POST

URL Params: Yok

Data Params:
{
  "order_items": [
    {
      "product_id": 1,
      "quantity": 2
    }
  ]
}

Başarı Yanıtı: Kod: 201 Created
İçerik:
{
  "status": "success",
  "order": {
    "id": 1,
    "user_id": 1,
    "items": [
      {
        "productId": 1,
        "quantity": 2
      }
    ],
    "order_amount": 200.00,
    "discounted_amount": 190.00,
    "shipping_cost": 10.00,
    "total_amount": 200.00,
    "applied_campaign": "5% discount for orders over 200 TL",
    "status": "pending"
  }
}

Hata Yanıtı: Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "order_items": ["The order_items field is required."],
    "order_items.*.product_id": ["The product_id field is required."],
    "order_items.*.quantity": ["The quantity field is required."]
  }
}

OR

Kod: 500 Internal Server Error
İçerik:
{
  "status": "error",
  "message": "An unexpected error occurred: {error_message}"
}
Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/orders" \
     -H "Content-Type: application/json" \
     -d '{"order_items": [{"product_id": 1, "quantity": 2}]}'
Notlar: Sipariş oluşturulurken ürün stokları güncellenir ve kampanya uygulanır.

## Sipariş Sil
URL: /api/v1/orders/{id}

Method: DELETE

URL Params: Required: id=[integer]

Data Params: Yok

Başarı Yanıtı: Kod: 200 OK

İçerik:
{
  "status": "success",
  "message": "Order with ID {id} successfully deleted"
}
Hata Yanıtı: Kod: 404 Not Found

İçerik:
{
  "status": "error",
  "message": "Order with ID {id} not found."
}

Örnek Çağrı:
curl -X DELETE "http://127.0.0.1:8000/api/v1/orders/1"
Notlar: Sipariş mevcut değilse, 404 hatası döner.



  # CampaignController API
CampaignController, kampanya yönetimi için API uç noktaları sağlar. Bu uç noktalar kampanyaların listelenmesini ve yeni kampanya eklenmesini sağlar.

## Kampanya Listesi
URL: /api/v1/campaigns

Method: GET

URL Params: Yok

Data Params: Yok

Başarı Yanıtı: Kod: 200 OK

İçerik:
{
  "status": "success",
  "data": [
    {
      "title": "Kampanya Başlığı",
      "type": "discount_for_author_origin"
    }
  ],
  "total": 10
}

Hata Yanıtı: Kod: 404 Not Found
İçerik:
{
  "status": "error",
  "message": "Bulunan sonuç sayfasında kampanya bulunamadı."
}

Örnek Çağrı:
curl -X GET "http://127.0.0.1:8000/api/v1/campaigns"
Notlar: Sayfalama kullanılır; döndürülen veriler sayfa numarası ve diğer sayfalama bilgilerini içerir.

## Yeni Kampanya Oluştur
URL: /api/v1/campaigns

Method: POST

URL Params: Yok

Data Params:
{
  "title": "Kampanya Başlığı",
  "type": "discount_for_author_origin",
  "value": 10,
  "discount_threshold": 100,
  "category_id": 1,
  "author_id": 1,
  "author_origin_for_campaign": "local"
}

Başarı Yanıtı: Kod: 201 Created
İçerik:
{
  "status": "success",
  "message": "Campaign created successfully.",
  "campaign": {
    "id": 1,
    "title": "Kampanya Başlığı",
    "type": "discount_for_author_origin",
    "value": 10,
    "discount_threshold": 100,
    "category_id": 1,
    "author_id": 1,
    "author_origin_for_campaign": "local"
  }
}

Hata Yanıtı: Kod: 400 Bad Request
İçerik:
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."],
    "type": ["The selected type is invalid."],
    "value": ["The value must be a number."],
    "discount_threshold": ["The discount threshold must be a number."],
    "category_id": ["The selected category_id is invalid."],
    "author_id": ["The selected author_id is invalid."],
    "author_origin_for_campaign": ["The selected author_origin_for_campaign is invalid."]
  }
}

OR

Kod: 500 Internal Server Error
İçerik:
{
  "status": "error",
  "message": "An unexpected error occurred: {error_message}"
}

Örnek Çağrı:
curl -X POST "http://127.0.0.1:8000/api/v1/campaigns" \
     -H "Content-Type: application/json" \
     -d '{"title": "Kampanya Başlığı", "type": "discount_for_author_origin", "value": 10, "discount_threshold": 100, "category_id": 1, "author_id": 1, "author_origin_for_campaign": "local"}'
     
Notlar: store method'u sadece is_admin middleware'i ile erişilebilir.

## CampaignService
CampaignService, kampanya işlemlerini yönetir ve uygulamak için gerekli fonksiyonları içerir.

##applyBestCampaign
Açıklama: Belirtilen sipariş öğelerine ve sipariş miktarına göre en iyi kampanyayı uygular.

##Parametreler:
$orderItems: Sipariş öğeleri koleksiyonu (Collection).
$orderAmount: Sipariş toplam miktarı (float).

Dönüş Değeri:
{
  "discountedAmount": 190.00,
  "discount": 10.00,
  "appliedCampaign": "Discount for amount"
}

## Açıklama:
discountedAmount: Uygulanan kampanya sonrası indirimli sipariş tutarı.
discount: Uygulanan indirim miktarı.
appliedCampaign: Uygulanan kampanyanın başlığı.
createCampaign
Açıklama: Verilen verilerle yeni bir kampanya oluşturur.

Parametreler:
$validatedData: Kampanya oluşturma için doğrulanmış veri (array).

Dönüş Değeri:
{
  "id": 1,
  "title": "Kampanya Başlığı",
  "type": "discount_for_author_origin",
  "value": 10,
  "discount_threshold": 100,
  "category_id": 1,
  "author_id": 1,
  "author_origin_for_campaign": "local"
}

Açıklama: Oluşturulan kampanyanın tüm bilgileri.
