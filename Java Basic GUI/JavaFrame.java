import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class JavaFrame {

    public static void main(String[] args) {
        JFrame frame = new JFrame("Awayan");

        JLabel label = new JLabel("Enter your name:");
        label.setBorder(new EmptyBorder(10, 0, 10, 10));
        JTextField textField = new JTextField(20);
        JButton button = new JButton("Say Hello");

        JPanel panel = new JPanel(null);

        Dimension textFieldSize = textField.getPreferredSize();
        Dimension buttonSize = button.getPreferredSize();
        int width = Math.max(textFieldSize.width, buttonSize.width);
        int height = Math.max(textFieldSize.height, buttonSize.height);
        textField.setPreferredSize(new Dimension(width, height));
        button.setPreferredSize(new Dimension(width, height));

        textField.setBounds(0, 0, width, height);
        button.setBounds(0, height + 5, width, height);

        panel.add(textField);
        panel.add(button);

        frame.setLayout(new BorderLayout());

        frame.add(label, BorderLayout.NORTH);
        frame.add(panel, BorderLayout.CENTER);

        button.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String name = textField.getText();
                JOptionPane.showMessageDialog(frame, "Hello, " + name + "!");
            }
        });

        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.setSize(240, 133);
        frame.setLocationRelativeTo(null);
        frame.setVisible(true);
    }
}