public class Convertion {
	 private double celsiusTempt;
     private double fahrenheitTempt;
     private double newcelsiusTempt;
     private double newfahrenheitTempt;
     
     public double celsiusToFahrenheit(double celsiusTempt) {
    	 newfahrenheitTempt = (celsiusTempt * 9 / 5) + 32;
    	 System.out.println(celsiusTempt + " Celsius is equal to " + newfahrenheitTempt + " Fahrenheit");
    	 
    	 return newfahrenheitTempt;
     }
     public double fahrenheitToCelsius(double fahrenheitTempt) {
    	 newcelsiusTempt = (fahrenheitTempt - 32) * 5 / 9;
    	 System.out.println(fahrenheitTempt + " Fahrenheit is equal to " + newcelsiusTempt + " Celsius");
    	 
    	 return newcelsiusTempt;
     }
}
