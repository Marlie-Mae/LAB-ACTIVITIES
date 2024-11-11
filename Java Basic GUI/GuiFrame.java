import java.awt.*; // Where is the other button?
import javax.swing.*;

public class GuiFrame {
	public static void main(String[] args) {
		JFrame frame = new JFrame();
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setSize(new Dimension(300, 100));
		frame.setTitle("A frame");

		JButton button1 = new JButton();
		button1.setText("I'm a button");
		button1.setBackground(Color.BLUE);
		frame.add(button1);

		JButton button2 = new JButton();
		button2.setText("Click me!");
		button2.setBackground(Color.RED);

		JButton button3 = new JButton();
		button3.setText("Submit");
		button3.setBackground(Color.YELLOW);

		frame.setLayout(new FlowLayout());
		//frame.add(new JButton("Button 1"));
		frame.add(button2);
		frame.add(button1);
		frame.add(button3);

		frame.setVisible(true);
	}
}
