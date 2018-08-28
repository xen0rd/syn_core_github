package Synthia2;

import java.util.concurrent.TimeUnit;
import org.openqa.selenium.*;
//import org.openqa.selenium.chrome.ChromeDriver;
//import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.htmlunit.HtmlUnitDriver;


public class Synthia_Test {
    public static void main (String[] args){

        //System.setProperty("webdriver.gecko.driver", "/Users/yuri_thel/Documents/AutomationTesting/geckodriver");
        //WebDriver driver = new FirefoxDriver();
        WebDriver driver;
        driver = new HtmlUnitDriver(true);

        // open | / |
        String URL="http://synthia2.grizzlysts.com/";
        driver.get(URL);  //Navigate to URL
        driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);


    //@Test
    //public void testSuccessfulLogin() throws Exception {

        // click | css=b |
        driver.findElement(By.cssSelector("b")).click();
        // type | id=username | yuri
        driver.findElement(By.id("username")).clear();
        driver.findElement(By.id("username")).sendKeys("yuri");
        // type | id=password | Tes_001!
        driver.findElement(By.id("password")).clear();
        driver.findElement(By.id("password")).sendKeys("Tes_001!");
        // click | //button[@type='submit'] |
        driver.findElement(By.xpath("//button[@type='submit']")).click();
        // click | id=virtualThumbnail |
        driver.findElement(By.id("virtualThumbnail")).click();
        // click | //img[contains(@src,'http://synthia2.grizzlysts.com/uploads/thumbnails/phpB770012820181517145981.jpg')] |
        driver.findElement(By.xpath("//img[contains(@src,'http://synthia2.grizzlysts.com/uploads/thumbnails/phpB770012820181517145981.jpg')]")).click();
        // click | link=Add to Cart |
        driver.findElement(By.linkText("Add to Cart")).click();
        // click | //div[8]/a/span |
        driver.findElement(By.xpath("//div[8]/a/span")).click();
        // click | css=input.btn.btn-success |
        driver.findElement(By.cssSelector("input.btn.btn-success")).click();

    //@After
   // public void tearDown() throws Exception {
    //    driver.quit();
     //   String verificationErrorString = verificationErrors.toString();
     //   if (!"".equals(verificationErrorString)) {
     //       fail(verificationErrorString);
        }


    //private boolean isElementPresent(By by) {
    //    try {
        //       driver.findElement(by);
           // return true;
        //} catch (NoSuchElementException e) {
         //   return false;
        //}
    //}

    //private boolean isAlertPresent() {
      //  try {
        //    driver.switchTo().alert();
        //    return true;
        //} catch (NoAlertPresentException e) {
        //    return false;
        //}


    //private String closeAlertAndGetItsText() {
      //  try {
        //    Alert alert = driver.switchTo().alert();
          //  String alertText = alert.getText();
            //if (acceptNextAlert) {
              //  alert.accept();
            //} else {
              //  alert.dismiss();
            //}
            //return alertText;
        //} finally {
          //  acceptNextAlert = true;
        //}
    }
