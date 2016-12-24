$("#review-form").submit(function() {
	var bookid = $("#bookid").val();
	var review = $("#your-review").val();
	review = review.replace(/"/g, '\\"');
	$.ajax({
		type: "post",
		url: "services/feature.php",
		data: 
		{
			command:"review",
			bookid:bookid,
			review:review
		},
	}).done(function(data) {
		window.location.href = "book.php";
	});
	return false;
});

$("#editReview-form").submit(function() {
	var bookid = $("#bookid").val();
	var review = $("#your-review").val();
	review = review.replace(/"/g, '\\"');
	review = review.replace(/\n/g, '<br>');
	console.log(review);
	$.ajax({
		type: "post",
		url: "services/feature.php",
		data: 
		{
			command:"editReview",
			bookid:bookid,
			review:review
		},
	}).done(function(data) {
		window.location.href = "book.php";
	});
	return false;
});

$("#insert-form").submit(function() {
	var img_path = $("#insert-img_path").val();
	var title = $("#insert-title").val();
	var publisher = $("#insert-publisher").val();
	var author = $("#insert-author").val();
	var description = $("#insert-description").val();
	description = description.replace(/"/g, '\\"');
	description = description.replace(/\n/g, '<br>');
	var quantity = $("#insert-quantity").val();
	$.ajax({
		type: "post",
		url: "services/feature.php",
		data:
		{
			command:"add",
			title:title,
			img_path:img_path,
			publisher:publisher,
			author:author,
			description:description,
			quantity:quantity
		},
	}).done(function(data) {
		var jsonArray = JSON.parse(data);
		if(jsonArray['status'] === "sukses") {
			window.location.href = "book_admin.php";
		}
		else {
			$(".message").text("your image path is not a valid url");
		}
	});
	return false;
});

$("#login-form").submit(function() {
	var username = $("#username").val();
	var password = $("#password").val();
	$.ajax({
		type: "post",
		url: "services/feature.php",
		data:
		{
			command:"login",
			username:username,
			password:password
		},
	}).done(function(data) {
		var jsonArray = JSON.parse(data);
		if(jsonArray['status'] === "sukses") {
			if(jsonArray['role'] === "admin") {
				window.location.href = "admin.php";
			}
			else {
				window.location.href = "user.php";
			}
		}
		else {
			$(".message").text("your username or password is incorrect");
		}
	});
	return false;
});