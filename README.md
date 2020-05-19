site/index.php - View (Загрузка файла + таблица вывода, в случае успеха)

models/XmlForm - Модель
	Методы:
		renameFile - переименовывает файл
		saveFile - сохраняет файл
		upload - обработка файла с проверкой на условия и структуру
		deleteFile - удаление файла, если не соответствует условиям
		
SiteController - Контроллер (вся работа в actionIndex)
