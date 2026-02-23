## 1.Crear departamento

curl -X POST http://localhost/accesodatos/api/departamentos \
 -H "Content-Type: application/json" \
 -d '{
"departamento": "Recursos Humanos"
}'

## 2. Listar todos los departamentos

curl http://localhost/accesodatos/api/departamentos

## 3. Obtener un departamento por ID

curl http://localhost/accesodatos/api/departamentos/1

## 4. Actualizar un departamento

curl -X PUT http://localhost/accesodatos/api/departamentos/1 \
 -H "Content-Type: application/json" \
 -d '{
"departamento": "Marketing"
}'

## 5. Eliminar un departamento

curl -X DELETE http://localhost/accesodatos/api/departamentos/1

## 6. Crear skill

curl -X POST http://localhost/accesodatos/api/skills \
 -H "Content-Type: application/json" \
 -d '{
"nombre": "PHP"
}'

## 7. Listar todas las skills

curl http://localhost/accesodatos/api/skills

## 8. Obtener una skill por ID

curl http://localhost/accesodatos/api/skills/1

## 9. Actualizar una skill

curl -X PUT http://localhost/accesodatos/api/skills/1 \
 -H "Content-Type: application/json" \
 -d '{
"nombre": "JavaScript"
}'

## 10. Eliminar una skill

curl -X DELETE http://localhost/accesodatos/api/skills/1
