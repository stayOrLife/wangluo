<!-- 前台功能：
	登录，注册，导航，文章列表，文章详情，投稿功能，搜索，评论
后台功能：
	登录，注册，导航管理，文章管理，管理员管理，会员管理，评论管理，系统设置
设计数据库：
	管理员表：Admin(id,username,password,nickname,email,status,super,create_time,update_time,软删除delete_time)
	会员表: member(username,password,nickname,create_time,email,update_time,软删除delete_time);
	导航表tp_cate(id,name,sort,create_time,update_time,软删除delete_time);
	文章表article(id,title,desc,tags,content,is_top,cate_id,create_time,
		update_time,软删除delete_time);
		 -->