package com.example.test30.domain.information

import retrofit2.Call
import retrofit2.http.*

interface InformationInterface {

    @FormUrlEncoded
    @POST("InsertInformation.php")
    fun insertInformation(
        @Field("informationToken") informationToken: String,
        @Field("informationUid") informationUid: String,
        @Field("informationUserid") informationUserid: String
    ): Call<String>

    @FormUrlEncoded
    @POST("DeleteInformation.php")
    fun deleteInformation(
        @Field("informationToken") informationToken: String
    ): Call<String>

    @GET("SelectInformation.php")
    fun selectInformation(

    ):Call<String>

}