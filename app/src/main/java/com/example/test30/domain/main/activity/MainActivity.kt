package com.example.test30.domain.main.activity

import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.Window
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import com.example.test30.domain.util.MySharedPreferences
import com.example.test30.R
import com.example.test30.domain.firebase.FirebaseViewModel
import com.example.test30.domain.information.InformationInterface
import com.example.test30.domain.user.LoginInterface
import com.example.test30.domain.user.activity.CreateIdActivity
import com.example.test30.domain.user.activity.FindPwActivity
import com.example.test30.domain.user.model.UserDTO
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.auth.ktx.auth
//import com.google.firebase.firestore.FirebaseFirestore
//import com.google.firebase.firestore.ktx.firestoreSettings
import com.google.firebase.ktx.Firebase
import com.google.firebase.messaging.FirebaseMessaging
import kotlinx.android.synthetic.main.login_main.*
import kotlinx.android.synthetic.main.login_main.back_button
import kotlinx.android.synthetic.main.login_main.text1
import org.json.JSONObject
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.converter.scalars.ScalarsConverterFactory
import java.security.MessageDigest
import java.security.NoSuchAlgorithmException


class MainActivity : AppCompatActivity() {

    var auth : FirebaseAuth? = null
    //var firestore : FirebaseFirestore? = null
    private val firebaseViewModel : FirebaseViewModel
        get() {
            TODO()
        }

    init {
        instance = this
    }
    companion object {
        lateinit var instance: MainActivity
        fun MainActivityContext(): Context {
            return instance.applicationContext
        }
    }
    var userId = ""
    var userPw = ""
    var hashPw = ""
    var userToken = ""
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.login_main)

        if(intent.hasExtra("name") && intent.hasExtra("pw")){
            text1.setText(intent.getStringExtra("name"))
            text2.setText(intent.getStringExtra("pw"))
        }

        auth = Firebase.auth
        //firestore = FirebaseFirestore.getInstance()
        FirebaseMessaging.getInstance().token.addOnCompleteListener { task ->
            if(task.isSuccessful) {
                userToken = task.result
            }
        }

        loginbutton.setOnClickListener({

            if(text1.getText().toString().equals("") || text1.getText().toString() == null){
                error_text_login.text = "아이디를 입력해주세요."
            }
            else if(text1.getText().length < 8){
                error_text_login.text = "8자 이상 입력해주세요."
            }
            else if(text2.getText().toString().equals("") || text2.getText().toString() == null){
                error_text_login.text = "비밀번호를 입력해주세요."
            }
            else if(text2.getText().length < 8){
                error_text_login.text = "8자 이상 입력해주세요."
            }
            else {
                userId = text1.getText().toString()
                userPw = text2.getText().toString()
                hashPw = getHash(userPw)
                loginCheck(userId, hashPw)
            }

//            val intent = Intent(this, MainActivity2::class.java)
//            startActivity(intent)
//            overridePendingTransition(R.anim.slide_right_enter,R.anim.slide_right_exit)
        })
        back_button.setOnClickListener({
            val intent = Intent(this, StartActivity::class.java)
            startActivity(intent)
            ActivityCompat.finishAffinity(this)
            overridePendingTransition(R.anim.slide_left_enter, R.anim.slide_left_exit)
        })
        create_id_button.setOnClickListener({
            val intent = Intent(this, CreateIdActivity::class.java)
            startActivity(intent)
            ActivityCompat.finishAffinity(this)
            overridePendingTransition(R.anim.slide_right_enter, R.anim.slide_right_exit)
        })
        forget_pwbutton.setOnClickListener({
            val intent = Intent(this, FindPwActivity::class.java)
            startActivity(intent)
            ActivityCompat.finishAffinity(this)
            overridePendingTransition(R.anim.slide_right_enter, R.anim.slide_right_exit)
        })
    }
    override fun onBackPressed() {
        val intent = Intent(this, StartActivity::class.java)
        startActivity(intent)
        ActivityCompat.finishAffinity(this)
        overridePendingTransition(R.anim.slide_left_enter, R.anim.slide_left_exit)
    }

    private fun loginCheck(ID: String, PW: String) {

        val retrofit = Retrofit.Builder()
            .baseUrl("http://sejongcountry.dothome.co.kr/")
            .addConverterFactory(ScalarsConverterFactory.create())
            .addConverterFactory(GsonConverterFactory.create())
            .build()
        val service = retrofit.create(LoginInterface::class.java)
        val call: Call<String> = service.login(ID, PW)
        call.enqueue(object: Callback<String> {

            override fun onResponse(call: Call<String>, response: retrofit2.Response<String>) {
                if(response.isSuccessful && response.body() != null) {
                    var result = response.body().toString()
                    Log.d("Reg", "onResponse Success : " + response.toString())
                    Log.d("Reg", "onResponse Success : " + result)

                    val info = JSONObject(result)
                    val status = info.getString("status")

                    if(status.equals("true")) {
                        val TYPE = info.getString("type")
                        val NAME = info.getString("name")
                        val GUARDIAN = info.getString("guardian")

                        var tempId = userId + "@gmail.com"
                        loginFireBase(tempId, PW)

                        MySharedPreferences.setUserId(MainActivityContext(), ID)
                        MySharedPreferences.setUserPw(MainActivityContext(), PW)
                        MySharedPreferences.setUserType(MainActivityContext(), TYPE)
                        MySharedPreferences.setUserGuardian(MainActivityContext(), GUARDIAN)
                        MySharedPreferences.setUserName(MainActivityContext(), NAME)
                        Toast.makeText(
                            MainActivityContext(), "${
                                MySharedPreferences.getUserId(
                                    MainActivityContext()
                                )
                            }님 로그인 되었습니다.", Toast.LENGTH_SHORT).show()
                        if(TYPE.equals("1")) {
                            var intent = Intent(MainActivityContext(), MainActivity3::class.java)
                            startActivity(intent)
                            overridePendingTransition(
                                R.anim.slide_right_enter,
                                R.anim.slide_right_exit
                            )
                            finish()
                        }
                        else if(TYPE.equals("0")) {
                            var intent = Intent(MainActivityContext(), MainActivity2::class.java)
                            startActivity(intent)
                            overridePendingTransition(
                                R.anim.slide_right_enter,
                                R.anim.slide_right_exit
                            )
                            finish()
                        }

                    }
                    else if(status.equals("NoId")) {
                        error_text_login.text = "아이디가 존재하지 않습니다."
                    }
                    else if(status.equals("NoPw")) {
                        error_text_login.text = "비밀번호가 일치하지 않습니다."
                    }
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

    private fun loginFireBase(ID: String, PW: String) {
        auth?.signInWithEmailAndPassword(ID, PW)
            ?.addOnCompleteListener {
                    result ->
                if(result.isSuccessful) {
                    var userDTO = UserDTO()
                    userDTO.uId = auth?.currentUser?.uid
                    userDTO.userId = auth?.currentUser?.email
                    userDTO.token = userToken
                    //firestore?.collection("Information")?.document(userToken)?.set(userDTO)
                    insertInformation(userDTO)
                }
            }
    }

    private fun insertInformation(userDTO: UserDTO) {
        val retrofit = Retrofit.Builder()
            .baseUrl("http://sejongcountry.dothome.co.kr/")
            .addConverterFactory(ScalarsConverterFactory.create())
            .addConverterFactory(GsonConverterFactory.create())
            .build()
        val service = retrofit.create(InformationInterface::class.java)
        val call: Call<String> = service.insertInformation(userDTO.token!!, userDTO.uId!!, userDTO.userId!!)
        call.enqueue(object : Callback<String> {
            override fun onResponse(call: Call<String>, response: Response<String>) {
                if(response.isSuccessful && response.body() != null) {
                    var result = response.body().toString()
                    Log.d("Reg", "onResponse Success : " + response.toString())
                    Log.d("Reg", "onResponse Success : " + result)
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

    private fun getHash(str: String) : String {
        var digest: String = ""
        digest = try {
            val sh = MessageDigest.getInstance("SHA-256")
            sh.update(str.toByteArray())
            val byteData = sh.digest()

            val hexChars = "0123456789ABCDEF"
            val hex = CharArray(byteData.size * 2)
            for(i in byteData.indices) {
                val v = byteData[i].toInt() and 0xff
                hex[i * 2] = hexChars[v shr 4]
                hex[i * 2 + 1] = hexChars[v and 0xf]
            }

            String(hex)
        } catch(e: NoSuchAlgorithmException) {
            e.printStackTrace()
            ""
        }
        return digest
    }

}
