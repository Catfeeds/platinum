import axios from "axios";

var interfaceApi = {
  doMain:
    "https://pt-memberminapp.preciousplatinum.com.cn/testapi/public/index.php/",
  init() {
    interfaceApi.requestDomain = this.doMain + "kjasdjk/";
    interfaceApi.img_upload = interfaceApi.requestDomain + "common/img_upload";
    interfaceApi.file_upload = interfaceApi.requestDomain + "common/file_upload";
    interfaceApi.pageSize = 6;
    // interfaceApi.file_upload_f = interfaceApi.requestDomain + "common/file_upload_f";
    // interfaceApi.orderTemplate = this.doMain + "file/";
  },
  // file_upload:interfaceApi.requestDomain + "cmmmon/file_upload",
  axiosapi(name, method, data, cb) {
    var method = method || "POST";
    if (method == "GET") {
      axios
        .get(this.requestDomain + name, {
          params: data
        })
        .then(res => {
          cb(res.data);
        });
    } else {
      axios.post(this.requestDomain + name, data).then(res => {
        cb(res.data);
      });
    }
  },

  // 登录
  sign(data, cb) {
    this.axiosapi("sign", "GET", data, res => {
      cb(res);
    });
  },

  // 首页功能管理----------------start
  // 小票上传管理
  // 小票list
  receipt_list(data, cb) {
    this.axiosapi("receipt_list", undefined, data, res => {
      cb(res)
    });
  },
  // 小票初审
  receipt_pre_exa(data, cb) {
    this.axiosapi("receipt_pre_exa", undefined, data, res => {
      cb(res);
    });
  },
  // 小票复审
  receipt_to_re(data, cb) {
    this.axiosapi("receipt_to_re", undefined, data, res => {
      cb(res);
    });
  },

  // 小票互动详情
  receipt_interaction_get(data, cb) {
    this.axiosapi("receipt_interaction_get", "GET", data, res => {
      cb(res);
    });
  },

  // 小票互动修改
  receipt_interaction(data, cb) {
    this.axiosapi("receipt_interaction", undefined, data, res => {
      cb(res);
    });
  },

  // 小票导出
  receipt_excel(data, cb) {
    this.axiosapi("receipt-excel", undefined, data, res => {
      cb(res);
    });
  },

  //好友助力list
  shareuser_list(data, cb) {
    this.axiosapi("shareuser_list", undefined, data, res => {
      cb(res);
    });
  },

  // 用户list
  user_list(data, cb) {
    this.axiosapi("user_list", undefined, data, res => {
      cb(res);
    });
  },

  // 用户签到list
  usersignin_list(data, cb) {
    this.axiosapi("usersignin_list", undefined, data, res => {
      cb(res);
    });
  },


  // 返现券list
  withdrawal_list(data, cb) {
    this.axiosapi("withdrawal-list", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券删除
  withdrawal_de(data, cb) {
    this.axiosapi("withdrawal-de", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券添加
  withdrawal_add(data, cb) {
    this.axiosapi("withdrawal-add", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券详情
  withdrawal_deta(data, cb) {
    this.axiosapi("withdrawal-deta", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券修改
  withdrawal_up(data, cb) {
    this.axiosapi("withdrawal-up", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券每天list
  widayconfig_list(data, cb) {
    this.axiosapi("widayconfig-list", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券每天删除
  wwidayconfig_de(data, cb) {
    this.axiosapi("widayconfig-de", undefined, data, res => {
      cb(res);
    });
  },

  //返现券每天添加
  widayconfig_add(data, cb) {
    this.axiosapi("widayconfig-add", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券每天详情
  widayconfig_deta(data, cb) {
    this.axiosapi("widayconfig-deta", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券每天修改
  widayconfig_up(data, cb) {
    this.axiosapi("widayconfig-up", undefined, data, res => {
      cb(res);
    });
  },





  // 首页功能管理----------------end

  // 首页活动管理----------------start
  //线上互动详情
  get_online(data, cb) {
    this.axiosapi("get_online", "GET", data, res => {
      cb(res);
    });
  },

  // 线上互动修改
  online(data, cb) {
    this.axiosapi("online", undefined, data, res => {
      cb(res);
    });
  },

  // AR返现详情
  get_ar_data(data, cb) {
    this.axiosapi("get_ar_data", "GET", data, res => {
      cb(res);
    });
  },

  // AR返现修改
  ar_data(data, cb) {
    this.axiosapi("ar_data", undefined, data, res => {
      cb(res);
    });
  },

  // 活动list
  activity_list(data, cb) {
    this.axiosapi("activity_list", undefined, data, res => {
      cb(res);
    });
  },

  // 活动签到list
  useractivity_list(data, cb) {
    this.axiosapi("useractivity_list", undefined, data, res => {
      cb(res);
    });
  },

  // 活动添加
  activity_add(data, cb) {
    this.axiosapi("activity_add", undefined, data, res => {
      cb(res);
    });
  },

  // 活动详情
  activity_deta(data, cb) {
    this.axiosapi("activity_deta", "GET", data, res => {
      cb(res);
    });
  },

  // 活动修改
  activity_up(data, cb) {
    this.axiosapi("activity_up", undefined, data, res => {
      cb(res);
    });
  },
  // 首页活动管理----------------end

  // 积分商城管理 --start
  // 礼品list
  giftvoucher_list(data, cb) {
    this.axiosapi("giftvoucher_list", undefined, data, res => {
      cb(res);
    });
  },
  // 礼品详情
  giftvoucher_deta(data, cb) {
    this.axiosapi("giftvoucher_deta", "GET", data, res => {
      cb(res);
    });
  },

  // 礼品修改
  giftvoucher_up(data, cb) {
    this.axiosapi("giftvoucher_up", undefined, data, res => {
      cb(res);
    });
  },

  //礼品删除
  giftvoucher_de(data, cb) {
    this.axiosapi("giftvoucher_de", "GET", data, res => {
      cb(res);
    });
  },
  //礼品添加
  giftvoucher_add(data, cb) {
    this.axiosapi("giftvoucher_add", undefined, data, res => {
      cb(res);
    });
  },
  //礼品订单list
  giftorder_list(data, cb) {
    this.axiosapi("giftorder_list", undefined, data, res => {
      cb(res);
    });
  },

  //礼品订单详情
  giftorder_deta(data, cb) {
    this.axiosapi("giftorder_deta", "GET", data, res => {
      cb(res);
    });
  },

  //电子券list
  voucher_list(data, cb) {
    this.axiosapi("voucher_list", undefined, data, res => {
      cb(res);
    });
  },

  //电子券详情
  voucher_deta(data, cb) {
    this.axiosapi("voucher_deta", "GET", data, res => {
      cb(res);
    });
  },

  //电子券修改
  voucher_up(data, cb) {
    this.axiosapi("voucher_up", undefined, data, res => {
      cb(res);
    });
  },

  //电子券删除
  voucher_de(data, cb) {
    this.axiosapi("voucher_de", undefined, data, res => {
      cb(res);
    });
  },

  //电子券订单管理
  voucherorder_list(data, cb) {
    this.axiosapi("voucherorder_list", undefined, data, res => {
      cb(res);
    });
  },

  // 电子券添加
  voucher_add(data, cb) {
    this.axiosapi("voucher_add", undefined, data, res => {
      cb(res);
    });
  },

  // 电子券核销二维码查看
  voucher_qrcode(data, cb) {
    this.axiosapi("voucher-qrcode", undefined, data, res => {
      cb(res);
    });
  },

  // 分类list
  classs_list(data, cb) {
    this.axiosapi("classs_list", undefined, data, res => {
      cb(res);
    });
  },

  // 积分商城管理 --end

  // 会员管理 --start
  // 用户收货地址list
  member_addr_list(data, cb) {
    this.axiosapi("member_addr_list", undefined, data, res => {
      cb(res);
    });
  },

  //用户list
  member_user_int_list(data, cb) {
    this.axiosapi("member_user_int_list", undefined, data, res => {
      cb(res);
    });
  },

  // 用户积分明细
  member_int_list(data, cb) {
    this.axiosapi("member_int_list", undefined, data, res => {
      cb(res);
    });
  },


  // 积分事件list
  member_event_list(data, cb) {
    this.axiosapi("member_event_list", undefined, data, res => {
      cb(res);
    });
  },

  // 提现list
  userwithdrawal_list(data, cb) {
    this.axiosapi("userwithdrawal_list", undefined, data, res => {
      cb(res);
    });
  },

  // 提现审核
  userwithdrawal_up(data, cb) {
    this.axiosapi("userwithdrawal_up", undefined, data, res => {
      cb(res);
    });
  },

  // 返现券直接发放
  withdrawal_grant(data, cb) {
    this.axiosapi("withdrawal-grant", undefined, data, res => {
      cb(res);
    });
  },


  //礼品订单list
  giftorder_list(data, cb) {
    this.axiosapi("giftorder_list", undefined, data, res => {
      cb(res);
    });
  },

  // 积分商城-电子券管理
  // 快递list
  express(data, cb) {
    this.axiosapi("express", undefined, data, res => {
      cb(res);
    });
  },

  // 礼品订单物流信息刷新
  giftorder_express(data, cb) {
    this.axiosapi("giftorder_express", undefined, data, res => {
      cb(res);
    });
  },

  // 礼品订单发货
  giftorder_up(data, cb) {
    this.axiosapi("giftorder_up", undefined, data, res => {
      cb(res);
    });
  },

  // 会员管理 --end

  // 权利管理 ---start
  // 会员权益list
  user_equity_list(data, cb) {
    this.axiosapi("user_equity_list", undefined, data, res => {
      cb(res);
    });
  },

  // 会员权益修改
  user_equity_up(data, cb) {
    this.axiosapi("user_equity_up", undefined, data, res => {
      cb(res);
    });
  },

  // 会员章程修改
  constitution_up(data, cb) {
    this.axiosapi("constitution_up", undefined, data, res => {
      cb(res);
    });
  },

  // 会员章程list
  constitution_list(data, cb) {
    this.axiosapi("constitution_list", undefined, data, res => {
      cb(res);
    });
  },

  // FAQ修改
  faq_up(data, cb) {
    this.axiosapi("faq_up", undefined, data, res => {
      cb(res);
    });
  },

  // FAQlist
  faq_list(data, cb) {
    this.axiosapi("faq_list", undefined, data, res => {
      cb(res);
    });
  },

  // 权利管理 ---end

  // 导出 ---start
  // 好友助力导出
  shareuser_excel(data, cb) {
    this.axiosapi("shareuser-excel", undefined, data, res => {
      cb(res);
    });
  },

  // 用户导出
  user_excel(data, cb) {
    this.axiosapi("user-excel", undefined, data, res => {
      cb(res);
    });
  },

  // 用户签到导出
  usersignin_excel(data, cb) {
    this.axiosapi("usersignin-excel", undefined, data, res => {
      cb(res);
    });
  },


  // 活动签到导出
  useractivity_excel(data, cb) {
    this.axiosapi("useractivity-excel", undefined, data, res => {
      cb(res);
    });
  },

  // 礼品导出
  giftvoucher_excel(data, cb) {
    this.axiosapi("giftvoucher-excel", undefined, data, res => {
      cb(res);
    });
  },

  // 礼品订单导出(积分商城)
  giftorder_excel(data, cb) {
    this.axiosapi("giftorder-excel", undefined, data, res => {
      cb(res);
    });
  },

  // 电子券导出
  // 礼品导出
  voucher_excel(data, cb) {
    this.axiosapi("voucher-excel", undefined, data, res => {
      cb(res);
    });
  },

  // 电子券订单导出
  voucherorder_excel(data, cb) {
    this.axiosapi("voucherorder-excel", undefined, data, res => {
      cb(res);
    });
  },


  // 导出 ---end






  // ---------------超级方法--------------------start
  // ----用来导出列表的
  encodeUrl(obj) {
    let url = "";
    (function (obj) {
      let kvArr = Object.entries(obj);
      kvArr.forEach(v => {
        if (Object.prototype.toString.call(v[1]) == "[object Object]") {
          // arguments.callee(v[1]);
        } else {
          url += v.join("=") + "&";
        }
      });
    })(obj);
    return url.substring(0, url.length - 1);
  }

  // ---------------超级方法--------------------end
};

export { interfaceApi };
