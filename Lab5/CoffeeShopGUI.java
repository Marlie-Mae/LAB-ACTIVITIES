import javax.swing.*;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;
import java.awt.*;

public class CoffeeShopGUI {

    public static void main(String[] args) {
        JFrame frame = new JFrame("Marlie's Brew Haven");
        
        // Set the background image
        ImageIcon backgroundImage = new ImageIcon("bg.png");
        JLabel backgroundLabel = new JLabel(backgroundImage);
        backgroundLabel.setLayout(new FlowLayout());
        frame.setContentPane(backgroundLabel);

        ImageIcon logoIcon = new ImageIcon("logo1.png");
        Image scaledLogo = logoIcon.getImage().getScaledInstance(130, -1, Image.SCALE_SMOOTH);
        ImageIcon scaledIcon = new ImageIcon(scaledLogo);
        JLabel imgLabel = new JLabel(scaledIcon);

        // Panel to hold the logo label and text field
        JPanel textFieldPanel = new JPanel(new FlowLayout(FlowLayout.LEFT));
        textFieldPanel.setBorder(new EmptyBorder(0, 10, -75, 0));
        textFieldPanel.setOpaque(false); // Make panel transparent
        textFieldPanel.add(new JLabel("Name:"));
        JTextField nameTextField = new JTextField(15); // Define name text field
        textFieldPanel.add(nameTextField);
        textFieldPanel.add(imgLabel); 
        // Set a border for the logo label
        imgLabel.setBorder(new EmptyBorder(0, 90, 70, 5));
        
        
        // Panel to hold the order and quantity components
        JPanel orderPanel = new JPanel(new FlowLayout(FlowLayout.LEFT));
        orderPanel.setBorder(new EmptyBorder(0, 10, 10, 10));
        orderPanel.setOpaque(false); // Make panel transparent
        orderPanel.add(new JLabel("Order:"));
        String[] orders = {"Espresso", "Latte", "Cappuccino", "Mocha", "Americano"};
        JComboBox<String> orderComboBox = new JComboBox<>(orders);
        orderComboBox.setPreferredSize(new Dimension(170, orderComboBox.getPreferredSize().height));
        orderPanel.add(orderComboBox);
        orderPanel.add(Box.createHorizontalStrut(70)); // Adding some spacing
        orderPanel.add(new JLabel("Quantity:"));
        JTextField quantityTextField = new JTextField(5); // Define quantity text field
        orderPanel.add(quantityTextField);

        // Main panel for other components
        JPanel mainPanel = new JPanel(new BorderLayout());
        mainPanel.setOpaque(false); // Make panel transparent
        mainPanel.add(textFieldPanel, BorderLayout.NORTH);
        mainPanel.add(orderPanel, BorderLayout.CENTER);

        // Add table to display inputed data
        DefaultTableModel model = new DefaultTableModel();
        model.addColumn("Name");
        model.addColumn("Order");
        model.addColumn("Quantity");

        JTable table = new JTable(model);
        JScrollPane scrollPane = new JScrollPane(table);
        // Set the preferred size of the scroll pane
        scrollPane.setPreferredSize(new Dimension(620, 160)); //520/150

        // Add button to add data to table
        JButton addButton = new JButton("ADD");
        addButton.addActionListener(e -> {
            String name = nameTextField.getText();
            String order = (String) orderComboBox.getSelectedItem();
            String quantity = quantityTextField.getText();

            model.addRow(new Object[]{name, order, quantity});

            nameTextField.setText("");
            quantityTextField.setText("");
        });

        // Add components to the background label
        backgroundLabel.add(mainPanel, BorderLayout.NORTH);
        backgroundLabel.add(scrollPane, BorderLayout.CENTER);
        backgroundLabel.add(addButton, BorderLayout.SOUTH);

        
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack(); // Pack components to fit preferred sizes
        frame.setSize(700, 450); // 730/450
        frame.setLocationRelativeTo(null);
        frame.setVisible(true);
    }
}
