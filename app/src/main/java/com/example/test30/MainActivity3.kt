package com.example.test30

import android.content.Intent
import android.content.pm.PackageManager
import android.os.Bundle
import android.telephony.SmsManager
import android.util.Log
import android.view.View
import android.view.Window
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import androidx.core.content.ContextCompat
import kotlinx.android.synthetic.main.real_main.*
import kotlinx.android.synthetic.main.real_main.ge_button
import kotlinx.android.synthetic.main.real_main.gong_button
import kotlinx.android.synthetic.main.real_main.gun_button
import kotlinx.android.synthetic.main.real_main.lt_button
import kotlinx.android.synthetic.main.real_main.setting_button
import kotlinx.android.synthetic.main.real_main.singo_button
import kotlinx.android.synthetic.main.real_main_admin.*
import org.json.JSONObject
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.converter.scalars.ScalarsConverterFactory

class MainActivity3 : AppCompatActivity() {
    var mBackWait : Long = 0

    private val multiplePermissionsCode = 100
    private val requiredPermissions = arrayOf(
        android.Manifest.permission.SEND_SMS,
        android.Manifest.permission.RECEIVE_SMS
    )
    var PHONE = ""
    var MESSAGE = ""
    var smsManager = SmsManager.getDefault()
    var userId = ""

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        requestWindowFeature(Window.FEATURE_NO_TITLE);

        setContentView(R.layout.real_main_admin)

        checkPermissions()

        //SharedPreferences에 값이 저장되어있지 않을 때
        if(MySharedPreferences.getUserId(this).isNullOrBlank() || MySharedPreferences.getUserPw(this).isNullOrBlank() || MySharedPreferences.getUserType(this).isNullOrBlank()) {

        }
        else {  //SharedPreferences에 값이 저장되어 있을 때
            userId = MySharedPreferences.getUserId(this)
        }

        singo_button.setOnLongClickListener({
            sendSms(userId)
            Toast.makeText(applicationContext,"보호자에게 긴급문자가 전송되었습니다.",Toast.LENGTH_SHORT).show()
            true
        })

        ge_button.setOnClickListener({
            ge_button.visibility = View.GONE

            gun_button.visibility = View.VISIBLE
            gong_button.visibility = View.VISIBLE
        })
        lt_button.setOnClickListener({
            lt_button.visibility = View.GONE
            announce_speak_button.visibility = View.VISIBLE
            announce_write_button.visibility = View.VISIBLE
        })
        announce_write_button.setOnClickListener({
            val intent = Intent(this, GongjiInsertActivity::class.java)
            startActivity(intent)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        announce_speak_button.setOnClickListener({
            val intent = Intent(this, AnnounceSpeakActivity::class.java)
            startActivity(intent)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        gong_button.setOnClickListener({
            ge_button.visibility = View.VISIBLE
            gun_button.visibility = View.GONE
            gong_button.visibility = View.GONE
            val intent = Intent(this, SubActivity::class.java)
            startActivity(intent)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        gun_button.setOnClickListener({
            ge_button.visibility = View.VISIBLE
            gun_button.visibility = View.GONE
            gong_button.visibility = View.GONE
            val intent = Intent(this, SubActivity2::class.java)
            startActivity(intent)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        setting_button.setOnClickListener({
            ge_button.visibility = View.VISIBLE
            gun_button.visibility = View.GONE
            gong_button.visibility = View.GONE
            val intent = Intent(this, SettingActivity::class.java)
            startActivity(intent)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        Chat_button1.setOnClickListener({
            val intent = Intent(this, ChatBotActivity::class.java)
            startActivity(intent)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        user_menu1.setOnClickListener({
            val intent = Intent(this, Splash::class.java)
            startActivity(intent)
            ActivityCompat.finishAffinity(this)
            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
    }

    var time3: Long = 0
    override fun onBackPressed() {
        val time1 = System.currentTimeMillis()
        val time2 = time1 - time3
        if (time2 in 0..2000) {
            ActivityCompat.finishAffinity(this)
            System.exit(0)
        }
        else {
            time3 = time1
            Toast.makeText(applicationContext, "한번 더 누르시면 종료됩니다.",Toast.LENGTH_SHORT).show()
        }
    }

    private fun checkPermissions() {
        var rejectedPermissionList = ArrayList<String>()

        for(permission in requiredPermissions) {
            if(ContextCompat.checkSelfPermission(this, permission) != PackageManager.PERMISSION_GRANTED) {
                rejectedPermissionList.add(permission)
            }
        }

        if(rejectedPermissionList.isNotEmpty()) {
            val array = arrayOfNulls<String>(rejectedPermissionList.size)
            ActivityCompat.requestPermissions(this, rejectedPermissionList.toArray(array), multiplePermissionsCode)
        }
    }

    //권한 요청 결과함수
    override fun onRequestPermissionsResult(
        requestCode: Int,
        permissions: Array<String>,
        grantResults: IntArray
    ) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults)
        when(requestCode) {
            multiplePermissionsCode -> {
                if(grantResults.isNotEmpty()) {
                    for((i, permission) in permissions.withIndex()) {
                        if(grantResults[i] != PackageManager.PERMISSION_GRANTED) {
                            //권한 획득 실패
                            Log.i("TAG", "The user has denied to $permission")
                            Log.i("TAG", "I can't work for you anymore then. ByeBye!")
                        }
                    }
                }
            }
        }
    }

    private fun sendSms(ID: String) {
        val retrofit = Retrofit.Builder()
            .baseUrl("http://sejongcountry.dothome.co.kr/")
            .addConverterFactory(ScalarsConverterFactory.create())
            .addConverterFactory(GsonConverterFactory.create())
            .build()
        val service = retrofit.create(SmsInterface::class.java)
        val call: Call<String> = service.sendSms(ID)
        call.enqueue(object: Callback<String> {
            override fun onResponse(call: Call<String>, response: Response<String>) {
                if(response.isSuccessful && response.body() != null) {
                    var result = response.body().toString()
                    Log.d("Reg", "onResponse Success : " + response.toString())
                    Log.d("Reg", "onResponse Success : " + result)

                    val info = JSONObject(result)
                    val NAME = info.getString("NAME")
                    PHONE = info.getString("PHONE")

                    MESSAGE = NAME + "님께서 긴급호출을 요청하였습니다."

                    smsManager.sendTextMessage(PHONE, null, MESSAGE, null, null)
                }
                else {
                    Log.d("Reg", "onResponse Failed")
                }
            }

            override fun onFailure(call: Call<String>, t: Throwable) {
                Log.d("Reg", "error : " + t.message.toString())
            }
        })
    }
}